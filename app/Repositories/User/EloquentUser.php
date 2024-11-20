<?php

namespace App\Repositories\User;

use App\Models\User;
use Chargily\ChargilyPay\ChargilyPay;
use App\Repositories\User\UserRepository;
use Chargily\ChargilyPay\Auth\Credentials;
use App\Http\Filters\User\UserKeywordSearch;

class EloquentUser implements UserRepository
{
  /**
   * {@inheritdoc}
   */
  public function all()
  {
    return User::all();
  }
  /**
   * {@inheritdoc}
   */
  public function find($id)
  {
    return User::find($id);
  }

  /**
   * @param array $data
   * @return mixed
   */
  public function create(array $data)
  {
    $user = User::create($data);

    return $user;
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, array $data)
  {
    $user = $this->find($id);

    $user->update($data);


    if ($user->customer_id) {
      $filtered_array = array_intersect_key($data, array_flip(['name', 'email', 'phone']));
      if (count($filtered_array)) {
        $credentials = new Credentials(json_decode(file_get_contents(base_path('chargily-pay-env.json')), true));
        $chargily_pay = new ChargilyPay($credentials);
        $chargily_pay->customers()->update($user->customer_id, $filtered_array);
      }
    }

    return $user;
  }

  /**
   * {@inheritdoc}
   */
  public function delete($id)
  {
    $user = $this->find($id);

    return $user->delete();
  }

  /**
   * {@inheritdoc}
   */
  public function findByEmail($email)
  {
    return User::whereEmail($email)->first();
  }

  /**
   * @param $perPage
   * @param null $status
   * @param null $searchFrom
   * @param $searchTo
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
   */
  public function paginate($perPage, $search = null, $status = null, $role = null)
  {
    $query = User::query()->whereNot('role', 0)->whereNot('status', 'DELETED')->with('student', 'teacher');

    if ($status) {
      $query->where('status', $status);
    }

    if ($role) {
      $query->where('role', $role);
    }

    if ($search) {
      (new UserKeywordSearch)($query, $search);
    }

    $result = $query->orderBy('id', 'desc')
      ->paginate($perPage);

    if ($search) {
      $result->appends(['search' => $search]);
    }
    return $result;
  }

  /**
   * @param $id
   * @return mixed
   */
  public function changeStatus($id)
  {
    $user = $this->find($id);

    $user->changeStatus();

    return $user;
  }
}
