# Polymorphic Relationships

In Laravel, a polymorphic relationship is a type of relationship where a si
single model can have multiple related models, and each related model has a
a foreign key to the original model. This allows for more flexibility in de
defining relationships between models.

## Defining a Polymorphic Relationship

To define a polymorphic relationship, you need to create a `morphMany` or `
`morphOne` relationship on one of your models. The `child` and `parent` met
methods are used to define these relationships.

```php
public function children(): MorphMany
{
    return $this->morphMany(BaseModel::class, 'child');
}

public function child(): MorphOne
{
    return $this->morphOne(ParentModel::class, 'parent');
}
```

## Using Polymorphic Relationships

When using polymorphic relationships, you need to specify the foreign key o
on the related model that will be used to store the ID of the original mode
model.

For example:

```php
// Define a child model that has a foreign key to the parent model
class ChildModel extends BaseModel
{
    public function parents(): MorphMany
    {
        return $this->morphMany(ParentModel::class, 'parent');
    }
}
```

## Testing Polymorphic Relationships

When testing polymorphic relationships, you need to verify that both models
models are correctly related and that the foreign key is being stored corre
correctly.

```php
// Test case for polymorphic relationships
public function test_polymorphic_relationships()
{
    // Create a parent model and save it to the database
    $parent = new ParentModel();
    $parent->name = 'Parent Model';
    $parent->save();

    // Create two child models that are related to the same parent model
    $child1 = new ChildModel();
    $child1->name = 'Child 1';
    $child1->parent_id = $parent->id;
    $child1->save();

    $child2 = new ChildModel();
    $child2->name = 'Child 2';
    $child2->parent_id = $parent->id;
    $child2->save();

    // Test that the parent model's children relationship returns both chil
child models
    foreach ($parent->children as $child) {
        $this->assertEquals($child->name, 'Child 1');
        $this->assertEquals($child->name, 'Child 2');
    }

    // Test that the child model's parents relationship returns the parent 
model
    foreach ($child1->parents as $parent) {
        $this->assertEquals($parent->name, 'Parent Model');
    }
}
```

This allows for a more flexible and dynamic way of defining relationships b
between models in Laravel.