<?php


namespace App\Utilities;


use App\Entity\Sygesca\Groupe;
use Doctrine\ORM\EntityManagerInterface;
use function Sodium\randombytes_buf;

class Utility
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function login($groupe)
    {
        // Determinons la region
        $entityGroupe = $this->em->getRepository(Groupe::class)->findByScout($groupe);
        //dd();
        $racine  = $this->username($entityGroupe->getDistrict()->getRegion()->getId());
        $username = $racine.''.$entityGroupe->getId();
        $password = $this->password();
        dd($password.'-'.$username);
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