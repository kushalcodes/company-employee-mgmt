<?php 

class Login_service
{
  private $model;

  public function set_model($model)
  {
    $this->model = $model;
  }

  public function login($email, $password)
  {
    $user = $this->model->get_where([
      'email' => $email,
    ]);

    if ($user)
    {
      return password_verify($password, $user->password) ? $user : FALSE;
    }

    return FALSE;
  }

  public function admin_login($email, $password)
  {
    $user = $this->model->get_where([
      'email' => $email,
      'role' => 0
    ]);

    if ($user)
    {
      return password_verify($password, $user->password) ? $user : FALSE;
    }

    return FALSE;
  }

}

?>