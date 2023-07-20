<?php


namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use App\Services\Session;
use Aura\SqlQuery\QueryFactory;
use PDO;

final class UserRepository implements UserInterface
{
    const USERS_TABLE = 'users';

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
        $select->cols(["*"])
            ->from(self::USERS_TABLE);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getById($id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(["*"])
            ->from(self::USERS_TABLE)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function save(User $user) : string | bool
    {
        $insert = $this->queryFactory->newInsert();
        $insert->into(self::USERS_TABLE)
            ->cols(['name', 'email'])
            ->bindValues([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());

        return $this->pdo->lastInsertId();
    }

    public function update($id, array $data) : void
    {
        $binds = [];

        foreach ($data as $key => $value) {
            $binds[$key] = $value;
        }

        $update = $this->queryFactory->newUpdate();
        $update->table(self::USERS_TABLE)
            ->cols($binds)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete($id) : void
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from(self::USERS_TABLE)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

    public function emailExists($email) : bool
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['id'])
            ->from('users')
            ->where('email = :email')
            ->bindValue('email', $email);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetchColumn() !== false;
    }

    public function updateEmail($id = null, $email = null) : bool
    {
        if (! $id && $email) {
            return false;
        }

        if (self::emailExists($email)) {
            return false;
        } else {
            $this->update($id, ['email' => $email]);
        }

        return true;

    }

    public function updatePassword($id = null, $data = null) : bool
    {
        if (! $id && $data) {
            return false;
        }

        if ($data['password'] !== $data['passwordconf']) {
            Session::flash('incorrect-password', 'Incorrect confirmation');

        }

        $update = $this->queryFactory->newUpdate();
        $update->table('users')
            ->cols(['password'])
            ->where('id = :id')
            ->bindValue('id', $id)
            ->bindValue('password', password_hash($data['password'], PASSWORD_DEFAULT));

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
        return true;
    }

    public function updateStatus($id, $status)
    {
        $this->update($id, ['status' => $status]);
    }

    public function updateAvatarPath($userId, $avatarPath)
    {
        $update = $this->queryFactory->newUpdate();
        $update->table(self::USERS_TABLE)
            ->cols(['avatar'])
            ->where('id = :id')
            ->bindValue('id', $userId)
            ->bindValue('avatar', $avatarPath);


        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }



}
