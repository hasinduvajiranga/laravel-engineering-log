# Eloquent Date Mutators

Eloquent date mutators are a convenient way to handle date formatting and validation when working with dates in your Laravel application.

In the `User` model, we've defined two mutators: `getCreatedAtAttribute` and `setCreatedAtAttribute`. The `getCreatedAtAttribute` method is used to retrieve the value of the `created_at` attribute as a DateTime object. If the value is not set, it returns null. The `setCreatedAtAttribute` method is used to set the value of the `created_at` attribute as a string in the format 'Y-m-d H:i:s'.

Similarly, in the `Post` model, we've defined two mutators: `getPublishedAtAttribute` and `setPublishedAtAttribute`. The `getPublishedAtAttribute` method is used to retrieve the value of the `published_at` attribute as a Carbon object. If the value is not set, it returns null. The `setPublishedAtAttribute` method is used to set the value of the `published_at` attribute as a string in the format 'Y-m-d H:i:s'.

These mutators can be useful when you want to perform date-related operations or validation on your models without having to write custom logic.

Note that Eloquent supports other types of mutators as well, such as getters and setters for numeric attributes. However, date mutators are particularly useful because they allow you to easily handle date formatting and validation in a centralized way.