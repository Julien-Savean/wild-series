<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAM = [
        [
            "Walking Dead",
            "Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d'hommes et de femmes mené par l'officier Rick Grimes tente de survivre...",
            "https://dbseries.net/wp-content/uploads/2019/09/rqeYMLryjcawh2JeRpCVUDXYM5b-260x360.jpg",
            "USA",
            "2010",
            "4"
        ],
        [
            "La Casa del Papel",
            "Huit voleurs font une prise d'otages dans la Maison royale de la Monnaie d'Espagne, tandis qu'un génie du crime manipule la police pour mettre son plan à exécution.",
            "https://dbseries.net/wp-content/uploads/2019/09/1GCH1B9z2a27jrKMqGkA4e15xfg-260x360.jpg",
            "Espagne",
            "2017",
            "0",
        ],
        [
            "Squid Game",
            "Tentés par un prix alléchant en cas de victoire, des centaines de joueurs désargentés acceptent de s'affronter lors de jeux pour enfants aux enjeux mortels.",
            "https://dbseries.net/wp-content/uploads/2021/08/squid-game.jpg",
            "Corée",
            "2021",
            "1",
        ],
        [
            "Vikings",
            "Les exploits d'un groupe de vikings de la fin du 8ème siècle jusqu'au milieu du 11ème, mené par Ragnar Lodbrok, l'un des plus populaires héros viking de tous les temps, qui a régné quelques temps sur le Danemark et la Suède...",
            "https://dbseries.net/wp-content/uploads/2019/12/7OjoP-260x360.jpg",
            "Suède",
            "2013",
            "1",
        ],
        [
            "Game Of Thrones",
            "Il y a très longtemps, à une époque oubliée, une force a détruit l'équilibre des saisons. Dans un pays où l'été peut durer plusieurs années et l'hiver toute une vie, des forces sinistres et surnaturelles se pressent aux portes du Royaume des Sept Couronnes. La confrérie de la Garde de Nuit, protégeant le Royaume de toute créature pouvant provenir d'au-delà du Mur protecteur, n'a plus les ressources nécessaires pour assurer la sécurité de tous. Après un été de dix années, un hiver rigoureux s'abat sur le Royaume avec la promesse d'un avenir des plus sombres. Pendant ce temps, complots et rivalités se jouent sur le continent pour s'emparer du Trône de fer, le symbole du pouvoir absolu.",
            "https://dbseries.net/wp-content/uploads/2020/12/game-of-thrones-260x360.jpg",
            "Westeros",
            "2011",
            "3",
        ],
    ];

    private Slugify $slug;

    public function __construct(Slugify $slug)
    {
        $this->slug = $slug;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $key => $serie) {
            $program = new Program();
            $program->setTitle($serie[0]);
            $program->setSynopsis($serie[1]);
            $program->setPoster($serie[2]);
            $program->setCountry($serie[3]);
            $program->setYear($serie[4]);
            $program->setSlug($this->slug->generate($program->getTitle()));
            $program->setCategory($this->getReference('category_' . $serie[5]));
            //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
            for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
                $program->addActor($this->getReference('actor_' . $i));
            }
            $manager->persist($program);
            $this->addReference('program_' . $key, $program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }
}
