<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use Aura\SqlQuery\QueryFactory;
use PDO;

final class UserRepository implements UserInterface
{
    private QueryFactory $queryFactory;
    private readonly PDO $pdo;

    public function __construct(QueryFactory $queryFactory, PDO $db)
    {
        $this->queryFactory = $queryFactory;
        $this->pdo = $db;
    }

    public function getAll() : bool | array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['id', 'name', 'email'])
            ->from('users');

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById($id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['id', 'name', 'email'])
            ->from('users')
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function save(User $user) : string | bool
    {
        $insert = $this->queryFactory->newInsert();
        $insert->into('users')
            ->cols(['name', 'email'])
            ->bindValues([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    public function update(User $user) : void
    {
        $update = $this->queryFactory->newUpdate();
        $update->table('users')
            ->cols([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ])
            ->where('id = :id')
            ->bindValue('id', $user->getId());

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete(User $user) : void
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from('users')
            ->where('id = :id')
            ->bindValue('id', $user->getId());

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

    public function updatePassword(User $user, $newPassword)
    {
        $update = $this->queryFactory->newUpdate();
        $update->table('users')
            ->cols(['password'])
            ->where('id = :id')
            ->bindValue('id', $user->getId())
            ->bindValue('password', password_hash($newPassword, PASSWORD_DEFAULT));

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function updateAvatarPath($userId, $avatarPath)
    {
        $update = $this->queryFactory->newUpdate();
        $update->table('users')
            ->cols(['avatar'])
            ->where('id = :id')
            ->bindValue('id', $userId)
            ->bindValue('avatar', $avatarPath);


        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }



}
