<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASON = [
        [
            "0",
            "1",
            "2010",
            "Après une épidémie post-apocalyptique ayant transformé la quasi-totalité de la population américaine et mondiale en mort-vivants ou « rôdeurs », un groupe d'hommes et de femmes mené par l'adjoint du shérif du comté de Kings (en Géorgie) USA, Rick Grimes, tente de survivre…
            Ensemble, ils vont devoir tant bien que mal faire face à ce nouveau monde devenu méconnaissable, à travers leur périple dans le Sud profond des États-Unis",
        ],
        [
            "0",
            "2",
            "2011",
            "À la suite de l'explosion du CDC, le groupe de survivants mené par Rick Grimes arrive à la ferme des Greene pour survivre aux rôdeurs.",
        ],
        [
            "0",
            "3",
            "2012",
            "Cette saison suit les aventures de Rick Grimes, depuis l'arrivée de son groupe dans une prison jusqu'à la mort d'Andrea Harrison et l'accueil des habitants de Woodbury à la prison après une attaque du Gouverneur.",
        ],
        [
            "0",
            "4",
            "2013",
            "Plusieurs mois après les derniers évènements, les occupants de la prison, qui ont réussi à la sécuriser à nouveau depuis la disparition du Gouverneur, accueillent désormais une grande population de survivants et la vie reprend peu à peu son cours. Toutefois, les épreuves de Woodbury ont laissé des traces : Rick, qui n'est plus que « l'ombre de lui-même », refuse de porter son arme, allant même jusqu’à céder sa place de leader au sein du groupe à un Conseil qui se compose de Hershel, Sasha, Glenn, Daryl et Carol. Michonne quant à elle est déterminée à trouver et à tuer le Gouverneur pour venger la mort d'Andrea.",
        ],
        [
            "0",
            "5",
            "2014",
            "Rick et sa troupe ont fui le terminus et errent dans la nature jusqu'à être recueillis par un pasteur dans son église puis dans le lieu recherché de tous : Alexandria Safe Zone.",
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SEASON as $key => $saison){
            $season = new Season();
            $season->setProgram($this->getReference('program_' . $saison[0]));
            $season->setNumber($saison[1]);
            $season->setYear($saison[2]);
            $season->setDescription($saison[3]);
            $manager->persist($season);
            $this->addReference('season_' . $key, $season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}