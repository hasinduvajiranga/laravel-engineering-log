### Eloquent Model Replication

In Laravel, the Eloquent ORM provides a powerful and intuitive way to interact with your database. However, sometimes you need to replicate complex relationships between models.

#### One-To-Many (O2M) Relationship

To establish an O2M relationship between `User` and `Order`, we use the `hasMany` method:

```php
public function orders()
{
    return $this->hasMany(Order::class);
}
```

This tells Eloquent to look for a foreign key on the `orders` table that references the primary key of the `users` table.

#### Many-To-Many (M2M) Relationship

To establish an M2M relationship between `User` and `Offer`, we use the `belongsToMany` method:

```php
public function users()
{
    return $this->belongsToMany(User::class);
}
```

This tells Eloquent to look for a pivot table that connects the `offers` table with the `users` table.

#### Relationship Inversion

In an O2M relationship, we can also define an inverse relationship by using the `$relationKey` method:

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

This tells Eloquent that the `orders` method is the inverse of the `user()` method.

#### Factories

When working with factories, we can define a factory for each model using the `Factory` class:

```php
public function definition()
{
    return [
        'name' => $this->faker->name,
        'email' => $this->faker->unique()->safeEmail,
        'password' => bcrypt('password'),
    ];
}
```

This tells Eloquent to create a new instance of the `User` model using the factory.

By using these techniques, we can establish complex relationships between models and make our database interactions more efficient.