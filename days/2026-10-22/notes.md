# Eloquent API Contract Testing

Eloquent, Laravel's ORM, provides a robust set of features for modeling data and defining relationships between models. However, when it comes to testing the functionality of these models, it can be challenging to ensure that the contract (i.e., the expected behavior) is met.

API Contract Testing is a technique used to verify that a class or method adheres to an expected interface or set of rules. In the context of Eloquent, this involves verifying that the model's relationships are correctly defined, that fillable attributes are properly set, and that other business logic is executed as expected.

In the example above, we have created a `User` model with a one-to-many relationship to `Order`. We then write unit tests for this model to ensure that:

* The correct fillable attributes are being used.
* The order relation is correctly defined.
* Fillable attributes are properly set and persisted.

These tests can be run in isolation, using Pest or PHPUnit, to verify the contract of the `User` model. By writing these tests, we can have confidence that our Eloquent models are behaving as expected, which is essential for building robust and maintainable applications.

### Best Practices

* Use factories to create test data.
* Write comprehensive unit tests for your models.
* Verify relationships between models are correctly defined.
* Test fillable attributes are properly set and persisted.
* Use Pest or PHPUnit to write these tests.