<?php

namespace App\Models\Blog;

use App\Models\Blog\Post;
use App\Models\Lib\ClearsResponseCache;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
 use HasFactory;
 use ClearsResponseCache;

 /**
  * @var string
  */
 protected $table = 'blog_comments';
 /**
  * @var array<int, string>
  */
 protected $fillable = [
  'title',
  'content',
  'is_visible',
  'user_id',
  'blog_post_id',
 ];

 public function user(): BelongsTo
 {
  return $this->belongsTo(User::class);
 }

 public function post(): BelongsTo
 {
  return $this->belongsTo(Post::class, 'blog_post_id');
 }
}