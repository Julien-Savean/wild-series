<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODE = [
        [
            "Passé décomposé",
            "1",
            "Rick Grimes, shérif, est blessé à la suite d'une course-poursuite. Il se retrouve dans le coma. Cependant, lorsqu'il se réveille dans l'hôpital, il ne découvre que désolation et cadavres. Se rendant vite compte qu'il est seul, il décide d'essayer de retrouver sa femme Lori et son fils Carl. Lorsqu'il arrive chez lui, il s'aperçoit que sa maison est vide et que sa famille a disparu.",
            "0",
        ],
        [
            "Tripes",
            "2",
            "Rick Grimes, shérif, est blessé à la suite d'une course-poursuite. Il se retrouve dans le coma. Cependant, lorsqu'il se réveille dans l'hôpital, il ne découvre que désolation et cadavres. Se rendant vite compte qu'il est seul, il décide d'essayer de retrouver sa femme Lori et son fils Carl. Lorsqu'il arrive chez lui, il s'aperçoit que sa maison est vide et que sa famille a disparu.",
            "0",
        ],
        [
            "T’as qu’à discuter avec les grenouilles",
            "3",
            "De retour au camp avec le groupe de survivants du supermarché, Rick retrouve enfin et avec beaucoup d'émotion sa femme Lori et son fils Carl. Andrea quant à elle, rejoint sa jeune sœur Amy. Mais très vite, malgré l'intrusion d'un zombie près du camp, Rick décide, contre l'avis de Shane, de retourner à Atlanta chercher Merle Dixon ainsi que son sac d'armes abandonné en route et récupérer au passage le talkie-walkie laissé dans le sac et ainsi prévenir Morgan de ne pas se rendre dans le piège d'Atlanta. Il est accompagné de Daryl Dixon, le frère de Merle, plus jeune mais tout aussi violent, ainsi que Glenn qui connaît bien les lieux et T-Dog qui se sent redevable et Andrea.",
            "0",
        ],
        [
            "Le Gang",
            "4",
            "En cherchant Merle, le groupe essaie aussi, par la même occasion, de retrouver le sac d'armes mais un autre groupe de survivants, également en quête des armes, les attaque. Le groupe parvient à capturer un attaquant blessé, Miguelito, mais les autres assaillants s'enfuient en voiture en emmenant Glenn comme otage",
            "0",
        ],
        [
            "Feux de forêt",
            "5",
            "Les cadavres sont enterrés, ceux des rôdeurs brûlés, mais Andrea protège le corps d'Amy jusqu'à son réveil en rôdeur , pour finir par l'achever. Dale, la voyant totalement bouleversée, tente en vain de la réconforter. Jim, un des survivants, révèle qu'il a été mordu par un rôdeur durant l'attaque et les membres du groupe décident de l'amener au Centre pour le contrôle et la prévention des maladies, dans l'espoir d'y trouver un vaccin.",
            "0",
        ],
    ];
     private Slugify $slug;

    public function __construct(Slugify $slug)
    {
        $this->slug = $slug;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODE as $key => $epi) {
            $episode = new Episode();
            $episode->setTitle($epi[0]);
            $episode->setNumber($epi[1]);
            $episode->setSynopsis($epi[2]);
            $episode->setSeason($this->getReference('season_' . $epi[3]));
            $episode->setSlug($this->slug->generate($episode->getTitle()));
            $manager->persist($episode);
            $this->addReference('episode_' . $key, $episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          SeasonFixtures::class,
          ProgramFixtures::class,
        ];
    }
}
