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

**2. Use typed arrays with DocBlocks instead of `DataCollection`**
Spatie Laravel Data v4 supports native arrays typed via DocBlocks. This is the preferred C.O.R.E. way because it simplifies hydration, avoids immutability issues with `DataCollection`, and keeps the code cleaner. NEVER use `#[DataCollectionOf]` or `DataCollection`.

❌ **Bad (Cumbersome and violates new C.O.R.E. rules):**
```php
class CognitiveContextDTO extends Data
{
    public function __construct(
        #[DataCollectionOf(WorkerResultDTO::class)]
        public private(set) ?DataCollection $telemetry = null,
    ) {}
}
```

✅ **Good (Native typed arrays):**
```php
class CognitiveContextDTO extends Data
{
    public function __construct(
        /** @var array<int, WorkerResultDTO> */
        public private(set) array $telemetry = [],
    ) {}
    
    public function recordTelemetry(WorkerResultDTO $entry): self
    {
        $clone = clone $this;
        $clone->telemetry[] = $entry; // ✅ Simple array append works perfectly
        return $clone;
    }
}
```

**3. DO NOT use variadic parameters (`...$items`) or manual logic in DTO constructors.**
C.O.R.E. DTOs are pure data structures. Using variadic parameters or manual assignment logic in the constructor breaks Spatie Laravel Data's `::from()` hydration from JSON payloads.

❌ **Bad (Breaks JSON hydration):**
```php
class AiMessageData extends Data
{
    #[DataCollectionOf(CitationDTO::class)]
    public readonly DataCollection $citations;

    public function __construct(
        public readonly string $response,
        CitationDTO ...$citations, // ❌ Variadic parameter
    ) {
        // ❌ Manual logic in constructor
        $this->citations = CitationDTO::collect(array_values($citations), DataCollection::class);
    }
}
```

✅ **Good (Pure promoted properties):**
```php
class AiMessageData extends Data
{
    public function __construct(
        public readonly string $response,
        #[DataCollectionOf(CitationDTO::class)]
        public readonly ?DataCollection $citations = null, // ✅ Promoted property
    ) {}
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
