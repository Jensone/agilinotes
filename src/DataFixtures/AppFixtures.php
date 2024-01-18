<?php

namespace App\DataFixtures;

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

        $pp = ['default-1.jpg', 'default-2.jpg'];

        // Admin
        $amdin = new User();
        $amdin->setEmail('admin@agilinote.fr')
            ->setUsername('Admin')
            ->setPassword('$2y$13$4sr2MBkP1lmtRk1Vv4CY/OcioigqTACDskCFFtwhikydLCRx9HP.G')
            ->setRoles(['ROLE_ADMIN'])
            ->setJob('Développeur Full Stack')
            ->setImage($faker->randomElement($pp))
            ->setCreatedAt($faker->dateTimeBetween('-10 months'));
        $manager->persist($amdin);

        // User
        $usersArray = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@agilinote.fr')
                ->setUsername($faker->userName)
                ->setPassword('$2y$13$4sr2MBkP1lmtRk1Vv4CY/OcioigqTACDskCFFtwhikydLCRx9HP.G')
                ->setRoles(['ROLE_USER'])
                ->setJob($faker->jobTitle)
                ->setImage($faker->randomElement($pp))
                ->setCreatedAt($faker->dateTimeBetween('-9 months'));
            $manager->persist($user);
            array_push($usersArray, $user);
        }

        // Followings
        for ($i = 0; $i < 30; $i++) {
            $follower = $faker->randomElement($usersArray);
            $followed = $faker->randomElement($usersArray);

            if ($follower != $followed) {
                $follower->follow($followed);

                $manager->persist($follower);
            }
        }

        // Languages
        $languages = array(
            'HTML5',
            'CSS3',
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
            } elseif ($lang == 'SQL') {
                $lang = 'mysql';
            }
            $language->setIcon(
                'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/'
                    . strtolower($lang)
                    . '/'
                    . strtolower($lang)
                    . ($lang == 'Rust' ? '-plain.svg' : '-original.svg')
            );
            $manager->persist($language);
            array_push($languagesArray, $language);
        }

        // Snippets
        for ($i = 0; $i < 100; $i++) {
            $snippet = new Snippet();
            $snippet->setTitle($faker->text(50))
                ->setLanguage($faker->randomElement($languagesArray))
                ->setAuthor($faker->randomElement($usersArray))
                ->setDescription($faker->text(200))
                ->setContent($faker->text(500))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setIsPublished($faker->boolean(90))
                ->setIsPublic($faker->boolean(50));
            $manager->persist($snippet);
        }

        // Launch
        $manager->flush();
    }
}
