@php use App\Models\Allergen; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Вещества вызывающие аллергию') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Введите список вещества, на которые у вас аллергия, разделенные запятой.') }}
        </p>
    </header>

    <!-- Форма для добавления аллергенов -->
    <form method="post" action="{{ route('profile.add-allergens') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="allergens" :value="__('Введите аллергены (через запятую)')" />
            <x-text-input id="allergens" name="allergens" type="text" class="mt-1 block w-full" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('allergens')" />
        </div>

        <x-primary-button>{{ __('Добавить аллерген(ы)') }}</x-primary-button>
    </form>

    <!-- Список существующих аллергенов с кнопками для удаления -->
    <div class="mt-6 space-y-2">
        @if ($user->allergens && $user->allergens->count() > 0)
            @foreach ($user->allergens as $allergen)
                <div class="flex items-center justify-between p-2 bg-gray-100 rounded-md">
                    <span>{{ $allergen->name }}</span>

                    <!-- Форма для удаления аллергена -->
                    <form method="post" action="{{ route('profile.delete-allergen', $allergen) }}" class="inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            &times;
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <p class="text-sm text-gray-500">{{ __('Аллергены не указаны.') }}</p>
        @endif
    </div>
<br>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>

</section>
