<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\PlanAndSchema;
use App\Entity\Product;
use DateTimeImmutable;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $clientsList = [];
        $ordersList = [];
        $productsList = [];
        $plansAndSchemasList = [];

        for ($i = 0; $i < 20; $i++) {
            $client = new Client();
            $client
                ->setFactory($faker->company)
                ->setAddress($faker->address)
                ->setPostalCode($faker->numberBetween(10000, 99999))
                ->setCity($faker->city)
                ->setEmail($faker->email)
                ->setPhone($faker->phoneNumber)
                ->setContactPrimary($faker->name)
                ->setCreatedAt(new DateTimeImmutable('now'));
            $clientsList[] = $client;
            $manager->persist($client);
        }

        for ($i = 0; $i < 20; $i++) {
            $planAndSchema = new PlanAndSchema();
            $planAndSchema
                ->setTitle($faker->title())
                ->setDescription($faker->sentence)
                ->setImgUrl('img link')
                ->setPdfUrl('pdf link')
                ->setCreatedAt(new DateTimeImmutable('now'));
            $plansAndSchemasList[] = $planAndSchema;
            $manager->persist($planAndSchema);
        }

        for ($i = 0; $i < 20; $i++) {
            $startDate = \DateTimeImmutable::createFromMutable($faker->dateTime());
            $endDate = $faker->optional()->dateTime();
            $endDateImmutable = $endDate ? \DateTimeImmutable::createFromMutable($endDate) : new DateTimeImmutable('now');

            $product = new Product();
            $product
                ->setName($faker->word)
                ->setDescription($faker->sentence)
                ->setUnitPrice($faker->randomFloat(2, 1, 100))
                ->setSupplier($faker->company)
                ->setStartDate($startDate)
                ->setEndDate($endDateImmutable)
                ->setPlanAndSchema($plansAndSchemasList[array_rand($plansAndSchemasList)])
                ->setCreatedAt(new DateTimeImmutable('now'));
            // ->setStatus($faker->numberBetween(0, 10));

            $productsList[] = $product;
            $manager->persist($product);
        }

        for ($i = 0; $i < 20; $i++) {
            $order = new Order();
            $order
                ->setStartDate(\DateTimeImmutable::createFromMutable($faker->dateTime()))
                ->setClient($clientsList[array_rand($clientsList)])
                ->setCreatedAt(new DateTimeImmutable('now'));
            $ordersList[] = $order;

            $manager->persist($order);
        }

        $manager->flush();
    }
}
