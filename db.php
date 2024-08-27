<?php
class DB
{
    public PDO $pdo;
    private string $dsn = "mysql:host=localhost;dbname=stores;user=root";

    public function __construct()
    {
        $this->pdo = new PDO($this->dsn);
    }

    public function getStores(): array
    {
        $statement = $this->pdo->prepare("select * from stores as s join users as u on s.ownerId=u.id");
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function addStore($data)
    {
        $ownerId = '864571ef-5edb-11ef-a3ef-a85e45d4803b';
        // $createUUID = $this->pdo->prepare("select UUID() as id");
        // $createUUID->execute();

        // $uuid = $createUUID->fetch()['id'];

        // $createUser = $this->pdo->prepare('insert into users (id,fName,lName,email) values (?,?,?,?)');
        // $createUser->execute([$uuid, 'mna', 'mna', 'asd@abv.bg']);

        $createStore = $this->pdo->prepare('insert into stores (name,description,ownerId) values(?,?,?)');
        $createStore->execute([$data['name'], $data['description'], $ownerId]);
    }

    public function getStore($id)
    {
        $getStore = $this->pdo->prepare('select * from stores where storeId=:id');
        $getStore->execute([':id' => $id]);

        $store = $getStore->fetchAll(PDO::FETCH_ASSOC);
        return $store[0];
    }

    public function updateStore($id, $data)
    {
        $updateStore = $this->pdo->prepare('update stores set name=:name,description=:description where storeId=:id');
        $updateStore->execute([':name' => $data['name'], ':description' => $data['description'], ':id' => $id]);
    }

    public function register($user)
    {
        $hash = password_hash($user['password'], PASSWORD_BCRYPT);

        $registerUser = $this->pdo->prepare('insert into users (fName,lName,email,password) values (?,?,?,?)');
        $registerUser->execute(['ime1', 'ime2', $user['email'], $hash]);
    }
}
