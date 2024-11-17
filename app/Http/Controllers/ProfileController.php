<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Allergen;
use App\Models\SkinType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->load('skinType', 'allergens'),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSkinType(Request $request): RedirectResponse
    {
        $request->validate([
            'skin_type' => 'required|string|in:dry,oily,combination,sensitive,normal',
        ]);

        $user = auth()->user();

        // Обновить или создать запись в skin_types
        $user->skinType()->updateOrCreate(
            ['user_id' => $user->id],
            ['type' => $request->input('skin_type')]
        );

        return redirect()->back()->with('status', 'Тип кожи обновлен.');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addAllergens(Request $request): RedirectResponse
    {
        $request->validate([
            'allergens' => 'nullable|string|max:255', // Ввод через запятую
        ]);

        $user = auth()->user();
        $allergens = array_filter(array_map('trim', explode(',', $request->input('allergens'))));

        foreach ($allergens as $allergen) {
            $user->allergens()->create([
                'name' => trim($allergen),
            ]);
        }

        return redirect()->back()->with('status', 'Аллергены успешно добавлены.');
    }

    /**
     * @param Allergen $allergen
     * @return RedirectResponse
     */
    public function deleteAllergen(Allergen $allergen): RedirectResponse
    {
        $user = auth()->user();

        // Проверка, принадлежит ли аллерген текущему пользователю
        if ($user->id !== $allergen->user_id) {
            abort(403); // Если не принадлежит, то ошибка доступа
        }

        // Удаление аллергена
        $allergen->delete();

        // Перенаправление с сообщением
        return redirect()->back()->with('status', 'Аллерген успешно удален.');
    }

}
