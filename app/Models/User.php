<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'dni',
        'apellidos',
        'nacimiento',
        'email',
        'username',
        'password',
        'role',
        'status',
        'restablecimiento',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'username', 'status', 'role'])
            ->useLogName('usuario')
            ->logOnlyDirty();
    }

    public function isOnline(): bool
    {
        return cache()->has('user-is-online-' . $this->id);
    }

    // Relación con talleres (para estudiantes)
    public function talleres()
    {
        return $this->belongsToMany(Taller::class, 'inscripciones', 'user_id', 'taller_id')
                    ->withPivot(['fecha_inscripcion', 'estado'])
                    ->wherePivot('estado', 'activa');
    }

    // Verificar si es estudiante
    public function isEstudiante()
    {
        return $this->role === 'estudiante';
    }

    // Verificar si es administrador
    public function isAdmin()
    {
        return $this->role === 'administrador';
    }
}
