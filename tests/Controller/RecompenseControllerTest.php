<?php

namespace App\Test\Controller;

use App\Entity\Recompense;
use App\Repository\RecompenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecompenseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private RecompenseRepository $repository;
    private string $path = '/recompense/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Recompense::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recompense index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'recompense[NomRecp]' => 'Testing',
            'recompense[Niveau]' => 'Testing',
            'recompense[DescriptionRecp]' => 'Testing',
        ]);

        self::assertResponseRedirects('/recompense/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Recompense();
        $fixture->setNomRecp('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setDescriptionRecp('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recompense');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Recompense();
        $fixture->setNomRecp('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setDescriptionRecp('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'recompense[NomRecp]' => 'Something New',
            'recompense[Niveau]' => 'Something New',
            'recompense[DescriptionRecp]' => 'Something New',
        ]);

        self::assertResponseRedirects('/recompense/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomRecp());
        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getDescriptionRecp());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Recompense();
        $fixture->setNomRecp('My Title');
        $fixture->setNiveau('My Title');
        $fixture->setDescriptionRecp('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/recompense/');
    }
}
