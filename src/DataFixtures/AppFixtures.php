<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Asset;
use App\Entity\Consumable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Users
        $admin = new User();
        $admin->setEmail('admin@logikit.fr');
        $admin->setNom('Admin');
        $admin->setPrenom('IT');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $manager2 = new User();
        $manager2->setEmail('manager@logikit.fr');
        $manager2->setNom('Dupont');
        $manager2->setPrenom('Sophie');
        $manager2->setRoles(['ROLE_MANAGER']);
        $manager2->setPassword($this->hasher->hashPassword($manager2, 'manager123'));
        $manager->persist($manager2);

        $user = new User();
        $user->setEmail('user@logikit.fr');
        $user->setNom('Martin');
        $user->setPrenom('Thomas');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->hasher->hashPassword($user, 'user123'));
        $manager->persist($user);

        // Assets
       // Assets - 50 produits
$brands = ['Dell', 'HP', 'Apple', 'Lenovo', 'Asus', 'Acer', 'Microsoft'];
$models = ['Latitude 5420', 'EliteBook 840', 'MacBook Pro 14', 'ThinkPad X1', 'ZenBook', 'Aspire 7', 'Surface Pro'];
$statuses = ['available', 'assigned', 'maintenance', 'lost', 'retired'];
$categories = ['PC', 'Accessoire', 'Ecran', 'Telephone'];

for ($i = 1; $i <= 50; $i++) {
    $asset = new Asset();
    $brand = $brands[array_rand($brands)];
    $model = $models[array_rand($models)];
    $asset->setBrand($brand);
    $asset->setModel($model);
    $asset->setSerialNumber(strtoupper(substr($brand, 0, 2)) . '-2024-' . str_pad($i, 3, '0', STR_PAD_LEFT));
    $asset->setStatus($statuses[array_rand($statuses)]);
    $asset->setCategory($categories[array_rand($categories)]);
    $asset->setCreatedAt(new \DateTimeImmutable('-' . rand(0, 365) . ' days'));
    $manager->persist($asset);
}

        // Consommables
        $consumable1 = new Consumable();
        $consumable1->setName('Souris HP');
        $consumable1->setStockQuantity(4);
        $consumable1->setStockAlertThreshold(5);
        $manager->persist($consumable1);

        $consumable2 = new Consumable();
        $consumable2->setName('Chargeur Dell');
        $consumable2->setStockQuantity(10);
        $consumable2->setStockAlertThreshold(3);
        $manager->persist($consumable2);

        $manager->flush();
    }
}