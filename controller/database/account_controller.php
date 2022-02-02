<?php
require_once('database_controller.php');
require_once(__DIR__ . '/../../model/account/account.php');

class AccountController extends DatabaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create_account(Account $account): int   /* 0 => success / 1 => doublon / 2 => error on query */
    {

        $sql_doublon = 'SELECT * FROM account WHERE email = :email OR name = :name';

        $query_doublon = $this->_database->prepare($sql_doublon);
        $query_doublon->execute(array(
            'email' => $account->get_email(),
            'name' => $account->get_name()
        ));

        if (!empty($query_doublon->fetch()))
            return 1;

        $sql_create = 'INSERT INTO account (name, email, password, is_seller, is_admin) 
                       VALUES (:name, :email, :password, :is_seller, :is_admin)';

        $query_create = $this->_database->prepare($sql_create);
        $res = $query_create->execute(array(
            'name' => $account->get_name(),
            'email' => $account->get_email(),
            'password' => $account->get_password(),
            'is_seller' => $account->get_is_seller() ? 1 : 0,
            'is_admin' => $account->get_is_admin() ? 1 : 0
        ));

        return $res == true ? 0 : 2;
    }

    public function fetch_account(string $email, string $password): ?Account
    {
        $sql = 'SELECT * FROM account WHERE email= :email AND password= :pwd';

        $query = $this->_database->prepare($sql);
        $query->execute(array('email' => $email, 'pwd' => $password));

        $data = $query->fetch();

        if (empty($data)) {
            return null;
        }

        return new Account($data);
    }

    public function change_password(int $account_id, string $new_password): bool
    {
        $sql =  'UPDATE account SET password = :password WHERE id = :id';

        $query = $this->_database->prepare($sql);
        return  $query->execute(array('password' => $new_password, 'id' => $account_id));
    }

    public function get_account_name(int $account_id): string
    {
        $sql = 'SELECT name FROM account WHERE id = :aid';


        $query = $this->_database->prepare($sql);

        $query->execute(array('aid' => $account_id));

        return $query->fetch()['name'];
    }
}
