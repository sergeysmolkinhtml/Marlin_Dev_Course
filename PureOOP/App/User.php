<?php



class User
{
    private ?Database $db;
    private $data;
    private mixed $session_name;
    private bool $LoggedIn = false;


    public function __construct($user = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');

        if (! $user) {
            if (Session::exists($this->session_name)) {
                $user = Session::get($this->session_name);
                if ($this->find($user)) {
                    $this->LoggedIn = true;
                } else {
                    //logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields = []) : Void
    {
        $this->db->insert('users', $fields);
    }

    public function login($email = null, $password = null, $remember = false) : bool
    {
        if (! $email && ! $password && $this->exists()) {
            Session::put($this->session_name, $this->getData()->id);
        } else {
            $user = $this->find($email);
            if ($user) {
                if (password_verify($password, $this->getData()->password)) {
                    Session::put($this->session_name, $this->getData()->id);

                    if ($remember) {
                        $hash = hash('sha256', uniqid());
                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->getData()->id]);

                        if (! $hashCheck->getCount()) {
                            $this->db->insert('user_sessions', [
                                'user_id' => $this->getData()->id,
                                'hash' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put(Config::get('cookie.cookie_name'), $hash, Config::get('cookie.cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function exists() :Bool
    {
        return (isset($this->data));
    }

    public function find($value = null) : Bool
    {
        if(is_numeric($value)){
            $this->data = $this->db->get('users',['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users',['email', '=', $value])->first();
        }

        if($this->data){
            return true;
        }

        return false;
    }

    public function getData()
    {
        return $this->data;
    }

    public function isLoggedIn() : bool
    {
        return $this->LoggedIn;
    }

    public function logout() : void
    {
        Session::delete($this->session_name);
    }


}