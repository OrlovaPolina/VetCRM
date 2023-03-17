<?php

namespace App\Observers;

use App\Models\Events;

class EventObs
{
/**
 *  TODO
 * Создание записи/ обновление / удаление - должны обновлять вид календаря (должен работать как компонент)
 * Обновления должны приходить через ajax (Придумать как принудительно обновлять страницу пользователя)
 * Скорее всего нужно будет повешать обработчик на js на страницу, чтобы регистрировал все приходящие данные с контроллера 
 * Так же нужно придумать как эффективней пересобирать данные в календаре 
 * (Скорее всего должен быть заранее подготовленный вид json), чтобы после декода можно было перерендерить календарь
 * Удаления будут жёсткие(без возможности восстановитьЁ)
*/

    /**
     * Handle the Events "created" event.
     */
    public function created(Events $events): void
    {
        //
    }

    /**
     * Handle the Events "updated" event.
     */
    public function updated(Events $events): void
    {
        //
    }

    /**
     * Handle the Events "deleted" event.
     */
    public function deleted(Events $events): void
    {
        //
    }

    /**
     * Handle the Events "restored" event.
     */
    public function restored(Events $events): void
    {
        //
    }

    /**
     * Handle the Events "force deleted" event.
     */
    public function forceDeleted(Events $events): void
    {
        //
    }
}
