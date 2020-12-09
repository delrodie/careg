<?php


namespace App\Utilities;


use App\Entity\Sygesca\Groupe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\randombytes_buf;

class Utility
{
    private $em;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
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

    /**
     * Enreistrement des paramètres de connexion du super admin
     *
     * @return bool
     */
    public function superAdmin(){
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