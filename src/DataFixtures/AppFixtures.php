<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Listing;
use App\Entity\ListingCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('en_EN');

        $user = new User();
        $user->setEmail('xyz@xyz.com');
        $user->setPassword($this->encoder->encodePassword($user, '123456'));
        $user->setFirstname('ali');
        $user->setLastname('ali');

        $admin = new User();
        $admin->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setEmail('admin@admin.com');
        $user->setPassword($this->encoder->encodePassword($user, '123456'));
        $user->setFirstname('admin');
        $user->setLastname('admin');

        $manager->persist($user);
        $manager->flush();

        $category = new ListingCategory();
        $category->setName($faker->words(2, true));
        $manager->persist($category);
        $manager->flush();

        $listings = [];
        for($i=0; $i<30; $i++) {
            $listing = new Listing();
            $listing->setUser($user);
            $listing->setListingCategory($category);
            $listing->setPublished(new \DateTime());
            $listing->setName($faker->words(4, true));
            $listing->setDescription($faker->words(6, true));
            $listing->setPrice($faker->numberBetween(1000, 5000));
            $listing->setBeds($faker->numberBetween(1000, 5000));
            $listing->setGuests($faker->numberBetween(1000, 5000));
            $listing->setLongitude($faker->numberBetween(1000, 5000));
            $listing->setLatitude($faker->numberBetween(1000, 5000));
            $manager->persist($listing);
            $listings[] = $listing;
        }

        $manager->flush();

        $booking = new Booking();
        $booking->setUser($user);
        $booking->setStatus('active');
        $booking->setBookedFrom(new \DateTime());
        $booking->setBookedUntil($faker->dateTimeInInterval($startDate = 'now', $interval = '+ 5 days', $timezone = null));
        $booking->addListing($faker->randomElement($listings));
        $booking->addListing($faker->randomElement($listings));
        $booking->addListing($faker->randomElement($listings));

        $manager->persist($booking);
        $manager->flush();
    }
}