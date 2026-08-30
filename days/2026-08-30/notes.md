# Eloquent Soft Delete Cascading
Eloquent soft delete is a powerful feature that allows you to mark records as deleted without actually removing them from the database. This can be useful for maintaining a record of changes or for auditing purposes.

However, when using soft delete with cascading behavior, things get complicated. When a parent model (e.g., User) is soft deleted, its child models (e.g., Post and Comment) should also be considered as soft deleted. This is because the relationship between the user and their posts and comments should be broken.

To achieve this, we use the `whereHas` method provided by Eloquent to find related records that have a soft deleted parent record.

Here are some key points to consider when using soft delete with cascading behavior:

*   When soft deleting a parent model, make sure to also update any child models to reflect the deletion.
*   Use the `whereHas` method to find related records that have a soft deleted parent record.
*   Make sure to handle any business logic or constraints that may arise when updating related records.

By following these best practices and using Eloquent's built-in features, you can create robust applications with cascading soft delete behavior.