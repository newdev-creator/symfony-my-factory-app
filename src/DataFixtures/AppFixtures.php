<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasherm
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // EMPLOYEE
        $basicUserList = [];
        for ($i = 0; $i < 10; $i++) {
            $birthday = \DateTimeImmutable::createFromMutable($faker->dateTime());
            $basicUser = new User();
            $manager->persist($basicUser);

            $basicUser
                ->setEmail($faker->email())
                ->setPostNumber($faker->randomDigit())
                ->setStatus($faker->word())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setBirthday($birthday)
                ->setAddress($faker->address())
                ->setPostalCode($faker->postcode())
                ->setCity($faker->city())
                ->setPhone($faker->phoneNumber())
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setRoles(['ROLE_EMPLOYEE']);

            $hashedPassword = $this->passwordHasherm->hashPassword($basicUser, 'user');
            $basicUser->setPassword($hashedPassword);
            $basicUserList[] = $basicUser;
        }

        // SECRETARY
        for ($i = 0; $i < 1; $i++) {
            $adminUser = new User();
            $manager->persist($adminUser);

            $adminUser
                ->setEmail($faker->email())
                ->setPostNumber($faker->randomDigit())
                ->setStatus($faker->word())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setBirthday($birthday)
                ->setAddress($faker->address())
                ->setPostalCode($faker->postcode())
                ->setCity($faker->city())
                ->setPhone($faker->phoneNumber())
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setRoles(['ROLE_SECRETARY']);

            $hashedPassword = $this->passwordHasherm->hashPassword($adminUser, 'admin');
            $adminUser->setPassword($hashedPassword);
            $manager->persist($adminUser);
        }

        // DIRECTOR
        for ($i = 0; $i < 1; $i++) {
            $adminUser = new User();
            $manager->persist($adminUser);

            $adminUser
                ->setEmail($faker->email())
                ->setPostNumber($faker->randomDigit())
                ->setStatus($faker->word())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setBirthday($birthday)
                ->setAddress($faker->address())
                ->setPostalCode($faker->postcode())
                ->setCity($faker->city())
                ->setPhone($faker->phoneNumber())
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setRoles(['ROLE_DIRECTOR']);

            $hashedPassword = $this->passwordHasherm->hashPassword($adminUser, 'admin');
            $adminUser->setPassword($hashedPassword);
            $manager->persist($adminUser);
        }



        $manager->flush();
    }
}
