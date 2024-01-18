<?php

namespace App\DataFixtures;

use App\Entity\Following;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Snippet;
use App\Entity\Language;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Admin
        $amdin = new User();
        $amdin->setEmail('admin@agilinote.fr')
            ->setUsername('Admin')
            ->setPassword('$2y$13$4sr2MBkP1lmtRk1Vv4CY/OcioigqTACDskCFFtwhikydLCRx9HP.G')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($amdin);

        // User
        $usersArray = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@agilinote.fr')
                ->setUsername($faker->userName)
                ->setPassword('$2y$13$4sr2MBkP1lmtRk1Vv4CY/OcioigqTACDskCFFtwhikydLCRx9HP.G')
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
            array_push($usersArray, $user);
        }

        // Languages
        $languages = array(
            'HTML',
            'CSS',
            'JavaScript',
            'PHP',
            'Python',
            'Java',
            'C',
            'C++',
            'C#',
            'Ruby',
            'Rust',
            'Go',
            'Swift',
            'Kotlin',
            'TypeScript',
            'SQL',
            'Bash',
            'Autre'
        );
        $languagesArray = [];

        foreach ($languages as $lang) {
            $language = new Language();
            $language->setName($lang);
            if ($lang == 'C++' || $lang == 'C#') {
                $lang = str_replace('#', 'sharp', $lang);
                $lang = str_replace('+', 'plus', $lang);
            } elseif ($lang == 'Autre') {
                $lang = 'devicon';
            }
            $language->setIcon('https://cdn.jsdelivr.net/gh/devicons/devicon/icons/' . strtolower($lang) . '/' . strtolower($lang) .  '-original.svg');
            $manager->persist($language);
            array_push($languagesArray, $language);
        }

        // Snippets
        for ($i=0; $i < 100; $i++) { 
            $snippet = new Snippet();
            $snippet->setTitle($faker->text(120))
                ->setLanguage($faker->randomElement($languagesArray))
                ->setAuthor($faker->randomElement($usersArray))
                ->setContent($faker->text(500))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setIsPublished($faker->boolean(90))
                ->setIsPublic($faker->boolean(50))
                ;
            $manager->persist($snippet);
        }

        // Followings
        for ($i=0; $i < 40; $i++) { 
            $following = new Following();
            $following->addFollower($faker->randomElement($usersArray));
            
            $manager->persist($following);
        }

        $manager->flush();
    }
}
