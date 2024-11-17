@php use App\Models\SkinType; @endphp
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Тип кожи') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Выберите свой тип кожи для дальнейшей работы с нашим сервисом.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update-skin-type') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="skin_type" :value="__('Skin Type')"/>
            <select id="skin_type" name="skin_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                @foreach (SkinType::TYPES as $key => $label)
                    <option
                        value="{{ $key }}" {{ old('skin_type', $user->skinType->type ?? '') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('skin_type')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
