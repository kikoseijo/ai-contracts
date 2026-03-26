---
name: spatie-laravel-data
description: Create and manage Data Transfer Objects (DTOs), requests, and resources using Spatie Laravel Data v4. Use when the user mentions DTOs, Laravel Data, Spatie Data, or needs to handle request validation and resource transformation in Laravel.
---

# Spatie Laravel Data (v4)

## Quick Start
Always extend `Spatie\LaravelData\Data` when creating a new data object.

```php
use Spatie\LaravelData\Data;
use Carbon\CarbonImmutable;

class PostData extends Data
{
    public function __construct(
        public string $title,
        public string $content,
        public ?CarbonImmutable $published_at
    ) {}
}
```

## Instantiation
Use the static `from` method to quickly create data objects from arrays, Eloquent models, or requests:

```php
// From an array
$post = PostData::from([
    'title' => 'Hello World',
    'content' => 'My content',
    'published_at' => null,
]);

// From an Eloquent Model
$post = PostData::from(Post::findOrFail($id));
```

## Controllers & Request Validation
Inject the Data object directly into controller methods. Laravel Data will automatically validate the incoming request and instantiate the object.

```php
class DataController
{
    public function __invoke(PostData $postData)
    {
        // $postData is already validated and instantiated
        Post::create($postData->toArray());
        return redirect()->back();
    }
}
```

## Validation Rules
Laravel Data automatically infers validation rules based on PHP property types:
* `required` when a property cannot be `null`
* `nullable` when a property can be `null`
* `numeric` when a property type is `int` or `float`
* `string` when a property type is `string`
* `boolean` when a property type is `bool`
* `array` when a property type is `array`
* `enum:*` when a property type is a native enum

To add custom rules that cannot be inferred, use attributes from `Spatie\LaravelData\Attributes\Validation\`:

```php
use Spatie\LaravelData\Attributes\Validation\Min;

class PostData extends Data
{
    public function __construct(
        #[Min(5)]
        public string $title,
    ) {}
}
```

## Anti-Patterns & Best Practices

**1. DO NOT manually implement `toResponse` for basic JSON responses.**
Spatie Laravel Data objects automatically implement `Responsable` (via the `ResponsableData` trait in the base `Data` class). Returning a `Data` object from a controller automatically converts it to a JSON response. 

❌ **Bad (Redundant):**
```php
class AgentListResponseDTO extends Data
{
    public function __construct(
        public readonly DataCollection $agents,
    ) {}

    // ❌ DO NOT DO THIS: It is already handled by Spatie Laravel Data
    public function toResponse($request): JsonResponse
    {
        return response()->json($this, 200);
    }
}
```

✅ **Good:**
```php
class AgentListResponseDTO extends Data
{
    public function __construct(
        public readonly DataCollection $agents,
    ) {}
    // ✅ Just return the DTO from your controller, Laravel Data handles the response automatically
}
```

**2. DO NOT use raw arrays with `#[DataCollectionOf]`**
When using `#[DataCollectionOf]`, the property type MUST be `DataCollection` (or `?DataCollection`), NEVER `array`. This applies even if you are using PHP 8.4's asymmetric visibility (`public private(set)`).

❌ **Bad (Violates C.O.R.E. strict typing):**
```php
class CognitiveContextDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(WorkerResultDTO::class)]
        public private(set) array $telemetry = [], // ❌ NEVER USE array HERE
    ) {}
    
    public function recordTelemetry(WorkerResultDTO $entry): self
    {
        $clone = clone $this;
        $clone->telemetry[] = $entry; // ❌ Array append
        return $clone;
    }
}
```

✅ **Good (Strict DataCollection):**
```php
class CognitiveContextDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(WorkerResultDTO::class)]
        public private(set) ?DataCollection $telemetry = null, // ✅ Use ?DataCollection
    ) {}
    
    public function recordTelemetry(WorkerResultDTO $entry): self
    {
        $clone = clone $this;
        $items = $this->telemetry?->items() ?? [];
        $items[] = $entry;
        $clone->telemetry = WorkerResultDTO::collection($items); // ✅ Rebuild collection
        return $clone;
    }
}
```

## Advanced: Custom Base Data Classes
If you need custom functionality, you can build your own base data class using Spatie's traits and interfaces (e.g., `ResponsableData`, `IncludeableData`, `TransformableData`, `ValidateableData`).

```php
use Spatie\LaravelData\Concerns\BaseData;
use Spatie\LaravelData\Concerns\TransformableData;
use Spatie\LaravelData\Contracts\BaseData as BaseDataContract;
use Spatie\LaravelData\Contracts\TransformableData as TransformableDataContract;

abstract class CustomData implements BaseDataContract, TransformableDataContract
{
    use BaseData;
    use TransformableData;
}
```
