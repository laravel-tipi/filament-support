<?php

declare(strict_types=1);

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Tipi\Filament\Validation\FilamentValidator;

beforeEach(function (): void {
    $container = new Container;
    $container->instance(
        'validator',
        new Factory(new Translator(new ArrayLoader, 'en'), $container),
    );

    Facade::setFacadeApplication($container);
});

afterEach(function (): void {
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication(null);
});

it('returns validated data', function (): void {
    expect(FilamentValidator::validate(
        data: ['name' => 'Wine'],
        rules: ['name' => ['required', 'string']],
    ))->toBe(['name' => 'Wine']);
});

it('maps validation errors to the state path', function (): void {
    try {
        FilamentValidator::validate(
            data: ['name' => null],
            rules: ['name' => ['required']],
            statePath: 'translation',
        );
    } catch (ValidationException $exception) {
        expect($exception->errors())->toHaveKey('translation.name');

        return;
    }

    test()->fail('Expected a validation exception.');
});

it('creates a field failure at the state path', function (): void {
    try {
        FilamentValidator::fail(
            field: 'locale_code',
            message: 'Translation already exists.',
        );
    } catch (ValidationException $exception) {
        expect($exception->errors())->toBe([
            'data.locale_code' => ['Translation already exists.'],
        ]);

        return;
    }

    test()->fail('Expected a validation exception.');
});
