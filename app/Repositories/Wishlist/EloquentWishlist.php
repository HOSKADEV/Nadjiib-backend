<?php

namespace App\Repositories\Wishlist;

use App\Models\Wishlist;
use App\Repositories\Wishlist\WishlistRepository;

class EloquentWishlist implements WishlistRepository
{
    /**
     * {@inheritdoc}
     */
    public function all(){
      return Wishlist::all();
  }
  /**
   * {@inheritdoc}
   */
  public function find($id)
  {
      return Wishlist::find($id);
  }

  /**
   * @param array $data
   * @return mixed
   */
  public function create(array $data)
  {
      $wishlist = Wishlist::create($data);

      return $wishlist;
  }

  /**
   * {@inheritdoc}
   */
  public function update($id, array $data)
  {
      $wishlist = $this->find($id);

      $wishlist->update($data);

      return $wishlist;
  }

  /**
   * {@inheritdoc}
   */
  public function delete($id)
  {
      $wishlist = $this->find($id);

      return $wishlist->delete();
  }

  /**
   * @param $perPage
   * @param null $status
   * @param null $searchFrom
   * @param $searchTo
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|mixed
   */
  public function paginate($perPage, $courseId)
  {

      $wishlist = Wishlist::whereCourseId($courseId)->orderBy('id', 'desc')
                  ->paginate($perPage);

      return $wishlist;
  }
}
