<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];

    public function markAsRead()
    {
        $this->status = 'read';
        $this->save();
    }
   
    public function markAsUnread()
    {
        $this->status = 'unread';
        $this->save();
    }

    public function markAsArchived()
    {
        $this->status = 'archived';
        $this->save();
    }

    public function markAsUnarchived()
    {
        $this->status = 'read';
        $this->save();
    }

    public function markAsDeleted()
    {
        $this->status = 'deleted';
        $this->save();
    }

    public function permanentlyDelete()
    {
        $this->delete();
    }

    public function isRead()
    {
        return $this->status === 'read';
    }

    public function isUnread()
    {
        return $this->status === 'unread';
    }

    public function isArchived()
    {
        return $this->status === 'archived';
    }

    public function isDeleted()
    {
        return $this->status === 'deleted';
    }
    
}
