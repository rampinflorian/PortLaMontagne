<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = (new User())
            ->setEmail('contact@florianrampin.fr')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$ZnlsdnBzZmdsRGxzOFNQUw$TNcmf6eNHpehasfT0X24SxXsg3vMYrwWmVZb8XB7cug')
            ->setRoles(['ROLE_USER'])
            ->setFirstname('Florian')
            ->setLastname('Rampin');

        $this->addReference('User_DEV', $user);

        $manager->persist($user);

        for ($i = 0; $i < 19; $i++) {
            $faker = Factory::create('fr_FR');

            $article = (new Article())
                ->setCreatedAt(new \DateTime())
                ->setTitle($faker->text(20))
                ->setContent($faker->paragraph)
                ->setCreatedBy($this->getReference('User_DEV'))
                ->setImage('todo');

            $manager->persist($article);
        }

        $manager->flush();
    }
}
