# Eloquent API ETags

In Laravel's Eloquent ORM, when you retrieve a model from the database, it will automatically generate an ETag for that instance. The ETag is used to track changes to the instance.

However, by default, ETags are not generated for all models. You can force ETags to be generated for certain models using the `touches` property on the model.

In this example, we've modified the `Product` model to always generate an ETag when retrieved from the database. This allows us to track changes to products in our API responses.

When you modify a product and then retrieve it again, the ETag will be different because the instance has changed. We can use this information to determine if the data has been modified since we last retrieved it.

In the test, we first create a new `Product` instance and retrieve its ETag before modifying it. After modifying it, we retrieve the ETag again and assert that they are equal.

Next, we modify all products to force them to generate an ETag when retrieved from the database. We then create a new product and retrieve its ETag again, asserting that it is different from the original ETag because this instance has not been modified yet.