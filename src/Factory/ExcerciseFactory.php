<?php

namespace App\Factory;

use App\Entity\Excercise;
use App\Repository\ExcerciseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Excercise>
 *
 * @method static Excercise|Proxy createOne(array $attributes = [])
 * @method static Excercise[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Excercise|Proxy find(object|array|mixed $criteria)
 * @method static Excercise|Proxy findOrCreate(array $attributes)
 * @method static Excercise|Proxy first(string $sortedField = 'id')
 * @method static Excercise|Proxy last(string $sortedField = 'id')
 * @method static Excercise|Proxy random(array $attributes = [])
 * @method static Excercise|Proxy randomOrCreate(array $attributes = [])
 * @method static Excercise[]|Proxy[] all()
 * @method static Excercise[]|Proxy[] findBy(array $attributes)
 * @method static Excercise[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Excercise[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ExcerciseRepository|RepositoryProxy repository()
 * @method Excercise|Proxy create(array|callable $attributes = [])
 */
final class ExcerciseFactory extends ModelFactory
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
            'name' => self::faker()->word(2),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Excercise $excercise): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Excercise::class;
    }
}
