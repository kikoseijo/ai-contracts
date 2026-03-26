<?php

$files = shell_exec('grep -rl "DataCollectionOf" src/');
$files = explode("\n", trim($files));

foreach ($files as $file) {
    if (empty($file) || !file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    // Replace #[DataCollectionOf(Class::class)] public ?DataCollection $prop = null;
    // with /** @var array<int, Class>|null */ public ?array $prop = null;
    
    $content = preg_replace_callback(
        '/#\[DataCollectionOf\(([^:]+)::class\)\]\s+(public(?:\s+readonly)?(?:\s+private\(set\))?)\s+(?:\?)?DataCollection\s+\$([a-zA-Z0-9_]+)(?:\s*=\s*null)?\s*,?/',
        function ($matches) {
            $className = $matches[1];
            $visibility = $matches[2];
            $propName = $matches[3];
            
            // If it's readonly, we can't have a default value usually, unless it's null
            // But let's just use array and [] if it's not readonly, or ?array and null if it is
            if (strpos($visibility, 'readonly') !== false) {
                return "/** @var array<int, {$className}>|null */\n        {$visibility} ?array \${$propName} = null,";
            } else {
                return "/** @var array<int, {$className}> */\n        {$visibility} array \${$propName} = [],";
            }
        },
        $content
    );
    
    // Remove use Spatie\LaravelData\Attributes\DataCollectionOf;
    $content = preg_replace('/use Spatie\\\\LaravelData\\\\Attributes\\\\DataCollectionOf;\n/', '', $content);
    // Remove use Spatie\LaravelData\DataCollection;
    $content = preg_replace('/use Spatie\\\\LaravelData\\\\DataCollection;\n/', '', $content);
    
    file_put_contents($file, $content);
    echo "Fixed: $file\n";
}
