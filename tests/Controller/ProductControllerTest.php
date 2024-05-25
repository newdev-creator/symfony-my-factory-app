<?php

namespace App\Test\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/product/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Product::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'product[name]' => 'Testing',
            'product[description]' => 'Testing',
            'product[unitPrice]' => 'Testing',
            'product[supplier]' => 'Testing',
            'product[startDate]' => 'Testing',
            'product[endDate]' => 'Testing',
            'product[createdAt]' => 'Testing',
            'product[updatedAt]' => 'Testing',
            'product[isArchived]' => 'Testing',
            'product[planAndSchema]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setUnitPrice('My Title');
        $fixture->setSupplier('My Title');
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setIsArchived('My Title');
        $fixture->setPlanAndSchema('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Product');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setUnitPrice('Value');
        $fixture->setSupplier('Value');
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setIsArchived('Value');
        $fixture->setPlanAndSchema('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'product[name]' => 'Something New',
            'product[description]' => 'Something New',
            'product[unitPrice]' => 'Something New',
            'product[supplier]' => 'Something New',
            'product[startDate]' => 'Something New',
            'product[endDate]' => 'Something New',
            'product[createdAt]' => 'Something New',
            'product[updatedAt]' => 'Something New',
            'product[isArchived]' => 'Something New',
            'product[planAndSchema]' => 'Something New',
        ]);

        self::assertResponseRedirects('/product/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getUnitPrice());
        self::assertSame('Something New', $fixture[0]->getSupplier());
        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getIsArchived());
        self::assertSame('Something New', $fixture[0]->getPlanAndSchema());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Product();
        $fixture->setName('Value');
        $fixture->setDescription('Value');
        $fixture->setUnitPrice('Value');
        $fixture->setSupplier('Value');
        $fixture->setStartDate('Value');
        $fixture->setEndDate('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setIsArchived('Value');
        $fixture->setPlanAndSchema('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/product/');
        self::assertSame(0, $this->repository->count([]));
    }
}
