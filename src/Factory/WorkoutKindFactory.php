<?php

namespace App\Factory;

use App\Entity\WorkoutKind;
use App\Repository\WorkoutKindRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<WorkoutKind>
 *
 * @method static WorkoutKind|Proxy createOne(array $attributes = [])
 * @method static WorkoutKind[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static WorkoutKind|Proxy find(object|array|mixed $criteria)
 * @method static WorkoutKind|Proxy findOrCreate(array $attributes)
 * @method static WorkoutKind|Proxy first(string $sortedField = 'id')
 * @method static WorkoutKind|Proxy last(string $sortedField = 'id')
 * @method static WorkoutKind|Proxy random(array $attributes = [])
 * @method static WorkoutKind|Proxy randomOrCreate(array $attributes = [])
 * @method static WorkoutKind[]|Proxy[] all()
 * @method static WorkoutKind[]|Proxy[] findBy(array $attributes)
 * @method static WorkoutKind[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static WorkoutKind[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static WorkoutKindRepository|RepositoryProxy repository()
 * @method WorkoutKind|Proxy create(array|callable $attributes = [])
 */
final class WorkoutKindFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(WorkoutKind $workoutKind): void {})
        ;
    }

    protected static function getClass(): string
    {
        return WorkoutKind::class;
    }
}
