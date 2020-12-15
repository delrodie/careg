<?php


namespace App\Utilities;


use App\Entity\Participant;
use App\Entity\Sygesca\Groupe;
use App\Entity\Sygesca\Scout;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Utility
{
    private $em;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder )
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function registration($groupe, $email, $fonction = null)
    {
        // Determinons la region
        $entityGroupe = $this->em->getRepository(Groupe::class)->findByScout($groupe);

        // Generation des paramètres de connexion
        $racine  = $this->username($entityGroupe->getDistrict()->getRegion()->getId());
        $username = $racine.''.$entityGroupe->getId();
        $password = $this->password();

        if ($fonction === 'CN') {
            $role[] = 'ROLE_ADMIN';
            $username = $racine;

            // Verification de l'existence du groupe dans le système
            $verif = $this->em->getRepository(User::class)->findOneBy(['username'=>$username]);
            if ($verif) return false;
        }
        elseif ($fonction === 'NATIONAL') {
            $role[] = 'ROLE_NATION';
            $username = $racine.''.mt_rand(100,999);
            $exist = $this->em->getRepository(User::class)->findOneBy(['username'=>$username]);
            while ($exist){
                $username = $racine.''.mt_rand(100,999);
                $exist = $this->em->getRepository(User::class)->findOneBy(['username'=>$username]);
            }
        }
        elseif ($fonction === 'CR') {
            $role[] = 'ROLE_REGION';

            // Verification de l'existence du groupe dans le système
            $verif = $this->em->getRepository(User::class)->findOneBy(['groupe'=>$entityGroupe]);
            if ($verif) return false;
        }
        elseif ($fonction === 'CD') {
            $role[] = 'ROLE_DISTRICT';

            // Verification de l'existence du groupe dans le système
            $verif = $this->em->getRepository(User::class)->findOneBy(['groupe'=>$entityGroupe]);
            if ($verif) return false;
        }
        else {
            $role[] = 'ROLE_USER';

            // Verification de l'existence du groupe dans le système
            $verif = $this->em->getRepository(User::class)->findOneBy(['groupe'=>$entityGroupe]);
            if ($verif) return false;
        }

        // Enregistrement
        $user = new User();
        $user->setUsername($username);
        $user->setGroupe($entityGroupe);
        $user->setRoles($role);
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));

        $this->em->persist($user);
        $this->em->flush();

        $parametre = [
            'username' => $username,
            'password' => $password
        ];

        return $parametre;
    }


    public function participation($participant, $scout, $user)
    {
        $groupe = $this->em->getRepository(Groupe::class)->findOneBy(['id'=>$scout->getGroupe()->getId()]); //dd($groupe);

        $participant2 = new Participant();
        $participant2->setCarte($scout->getCarte());
        $participant2->setNom($scout->getNom());
        $participant2->setPrenoms($scout->getPrenoms());
        $participant2->setDateNaissance($scout->getDatenaiss());
        $participant2->setLieuNaissance($scout->getLieunaiss());
        $participant2->setSexe($scout->getSexe());
        $participant2->setBranche($scout->getBranche());
        $participant2->setFonction($scout->getFonction());
        $participant2->setContact($scout->getContact());
        $participant2->setUrgance($scout->getContactParent());
        $participant2->setStatut($scout->getStatut()->getLibelle());
        $participant2->setGroupe($groupe);
        $participant2->setCreatedBy($user);
        $participant2->setActivite($participant->getActivite());
        $participant2->setMatricule($participant->getMatricule());

        $this->em->persist($participant2); //dd($participant2);
        $this->em->flush();

        return true;
    }

    /**
     * Enreistrement des paramètres de connexion du super admin
     *
     * @return bool
     */
    public function superAdmin(){
        $exist = $this->em->getRepository(User::class)->findOneBy(['email'=>"delrodieamoikon@gmail.com"]);
        if ($exist) return false;
        $role[] = 'ROLE_SUPER_ADMIN';
        $user = new User();
        $user->setUsername('delrodie');
        $user->setRoles($role);
        $user->setEmail('delrodieamoikon@gmail.com');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$cuHTsOx0X7QbK/zwQJsJzw$5FniCUXUa8mszHhPU8DSMZE5iG9eaYNe+DTebifVFIE');

        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * Libelisation des niveaux
     *
     * @param $niveau
     * @return string
     */
    public function niveau($niveau)
    {
        switch ($niveau){
            case 1:
                $libelle = "Uniquement Equipe nationale";
                break;
            case 2:
                $libelle = "L'équipe nationale et les régionaux";
                break;
            case 3:
                $libelle = "Uniquement les chefs";
                break;
            case 4:
                $libelle = "Tous les scouts";
                break;
            case 5:
                $libelle = "Uniquement Equipe régionale";
                break;
            case 6:
                $libelle = "Equipe régionale et les CD";
                break;
            case 7:
                $libelle = "Uniquement les chefs de la région";
                break;
            case 8:
                $libelle = "Tous les scouts de la région";
                break;
            case 9:
                $libelle = "Uniquement Equipe de district";
                break;
            case 10:
                $libelle = "Equipe de district et les CG";
                break;
            case 11:
                $libelle = "Uniquement les chefs du district";
                break;
            case 12:
                $libelle = "Tous les socuts du district";
                break;
            case 13:
                $libelle = "Uniquement les chefs du groupe";
                break;
            case 14:
                $libelle = "Tous les scouts du groupe";
                break;
        }

        return $libelle;
    }

    /**
     * Année de cotisation du scout
     *
     * @return string
     */
    public function annee()
    {
        $mois_encours = Date('m', time());
        if ($mois_encours > 9){
            $debut_annee = Date('Y', time());
            $fin_annee = Date('Y', time())+1;
            //$an = Date('y', time())+1;
        }else{
            $debut_annee = Date('Y', time())-1;
            $fin_annee = Date('Y', time());
            //$an = Date('y', time());
        }

        $annee = $debut_annee.'-'.$fin_annee;

        return $annee;
    }

    /**
     * Generation du login
     *
     * @param $region
     */
    protected function username($region)
    {
        switch ($region){
            case 1:
                $nom = "national";
                break;
            case 4:
                $nom = "abengourou";
                break;
            case 5:
                $nom = "abidjan";
                break;
            case 6:
                $nom = "agboville";
                break;
            case 7:
                $nom = "bondoukou";
                break;
            case 8:
                $nom = "bouake";
                break;
            case 9:
                $nom =  "daloa";
                break;
            case 10:
                $nom = "gagnoa";
                break;
            case 11:
                $nom = "bassam";
                break;
            case 12:
                $nom = "katiola";
                break;
            case 13:
                $nom = "korhogo";
                break;
            case 14:
                $nom = "man14";
                break;
            case 15:
                $nom = "odienne";
                break;
            case 16:
                $nom = "spedro";
                break;
            case 17:
                $nom = "yakro";
                break;
            case 18:
                $nom = "yopougon";
                break;
        }

        return $nom;
    }

    protected function password()
    {
        $code = "abcdefghijklmnopqrstuvwxyz0123456789";

        for ($i=0; $i < 8; $i++){
            $pass[$i] = $code[rand(0,35)];
        }
        $password = $pass[0].''.$pass[1].''.$pass[2].''.$pass[3].''.$pass[4].''.$pass[5].''.$pass[6].''.$pass[7];
        return $password;
    }
}