<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\MarketProduct;
use App\Entity\Topo;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = (new User())
            ->setEmail('contact@florianrampin.fr')
            ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$ZnlsdnBzZmdsRGxzOFNQUw$TNcmf6eNHpehasfT0X24SxXsg3vMYrwWmVZb8XB7cug') //b!
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('Florian')
            ->setLastname('Rampin')
            ->setImage('')
            ->setDescription($faker->text(90));

        $this->addReference('User_DEV', $user);
        $manager->persist($user);

        $category = (new Category())
            ->setTitle('Information');

        $manager->persist($category);

        for ($i = 0; $i < 4; $i++) {
            $faker = Factory::create('fr_FR');

            $topo = (new Topo())
                ->setTitle($faker->text(10))
                ->setLink('https://fake.fr')
                ->setPrice($faker->numberBetween(0.99, 59.99))
                ->setCreatedAt(new \DateTime())
                ->setImage('defaultTopo-5f01f39c5558f.png')
                ->setImageSecond('defaultTopo-2-5f01f39c5558f.png')
                ->setStar($faker->numberBetween(1, 5))
                ->setIsSoldOut($faker->boolean);
            $manager->persist($topo);

        }

        for ($i = 0; $i < 19; $i++) {
            $faker = Factory::create('fr_FR');

            $article = (new Article())
                ->setCreatedAt(new \DateTime())
                ->setTitle($faker->text(20))
                ->setContent($faker->paragraph)
                ->setUser($this->getReference('User_DEV'))
                ->setImage('1k_merci-5f6759c5d0ce3.jpg')
                ->setCategory($category)
                ->setIsPublished(true);

            $manager->persist($article);
        }

        for ($i = 0 ; $i < 29 ; $i++) {
            $faker = Factory::create('fr_FR');

            $date = $faker->dateTimeBetween('-1 years', '-1 months');

            $marketProduct = (new MarketProduct())
                ->setTitle($faker->text(20))
                ->setDescription($faker->text(255))
                ->setPrice($faker->randomFloat(2, 9.99, 999.99))
                ->setIsSold($faker->boolean)
                ->setIsSuspended($faker->boolean)
                ->setCreatedAt($date)
                ->setUpdatedAt($date)
                ->setBuyer($user)
                ->setVendor($user)
                ->setImageFirst('')
                ;

            $manager->persist($marketProduct);
        }

        $manager->flush();
    }
}
