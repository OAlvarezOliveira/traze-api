<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{

    private UserPasswordHasherInterface  $hasher;
    private EntityManagerInterface    $managerEntity;

    public function __construct(UserPasswordHasherInterface  $hasher ,EntityManagerInterface    $managerEntity)
    {
        parent::__construct();
        $this->hasher = $hasher;
        $this->managerEntity = $managerEntity;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email del usuario')
            ->addArgument('password', InputArgument::REQUIRED, 'Contraseña del usuario')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = new User();

        //Hashear la contraseña
        $hashedPassword = $this->hasher->hashPassword($user, $password);

        //asignar los datos con los setter
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);

        //persistir y guardar en BD
        $this->managerEntity->persist($user);
        $this->managerEntity->flush();

        $io->success('Usuario creado: ' . $email);
        return Command::SUCCESS;
    }
}
