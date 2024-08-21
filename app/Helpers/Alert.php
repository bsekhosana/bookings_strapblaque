<?php

namespace App\Helpers;

use App\Enums\AlertAction;

class Alert
{
    private static string $session_key = 'sweetAlert';

    /** @var \App\Enums\AlertAction */
    const Approved = AlertAction::Approve;

    /** @var \App\Enums\AlertAction */
    const Deleted = AlertAction::Delete;

    /** @var \App\Enums\AlertAction */
    const Denied = AlertAction::Deny;

    /** @var \App\Enums\AlertAction */
    const Destroyed = AlertAction::Destroy;

    /** @var \App\Enums\AlertAction */
    const Removed = AlertAction::Remove;

    /** @var \App\Enums\AlertAction */
    const Restored = AlertAction::Restore;

    /** @var \App\Enums\AlertAction */
    const Sent = AlertAction::Send;

    /** @var \App\Enums\AlertAction */
    const Stored = AlertAction::Store;

    /** @var \App\Enums\AlertAction */
    const Trashed = AlertAction::Trash;

    /** @var \App\Enums\AlertAction */
    const Updated = AlertAction::Update;

    /**
     * Display success message.
     */
    public static function success(string $text, int $timer = 1900, int $priority = 1): void
    {
        self::custom($text, 'success', 'Success', $timer, $priority);
    }

    /**
     * Display warning message.
     */
    public static function warning(string $text, int $timer = 2500, int $priority = 1): void
    {
        self::custom($text, 'warning', 'Warning', $timer, $priority);
    }

    /**
     * Display error message.
     */
    public static function error(string $text, int $timer = 3100, int $priority = 1): void
    {
        self::custom($text, 'error', 'Failed', $timer, $priority);
    }

    /**
     * Show alert according to CRUD results.
     */
    public static function crud(mixed $success, AlertAction $action, ?string $context = null, int $timer = 1900, int $priority = 1): void
    {
        $success = (bool) $success;

        $icon = $success ? 'success' : 'error';
        $title = $success ? 'Success' : 'Failed';

        self::custom($action->message($success, $context), $icon, $title, $timer, $priority);
    }

    /**
     * Display custom message.
     */
    public static function custom(string $text, string $icon = 'warning', string $title = 'Alert', int $timer = 3000, int $priority = 1): void
    {
        if (\Session::has(self::$session_key)) {
            $old_alert = json_decode(\Session::get(self::$session_key));

            // If the old alert's priority is higher, discard new alert.
            if ($old_alert->priority > $priority) {
                return;
            }
        }

        \Session::flash(self::$session_key, json_encode([
            'title'    => $title,
            'text'     => ucfirst($text),
            'icon'     => $icon,
            'timer'    => $timer,
            'buttons'  => false,
            'priority' => $priority,
        ]));
    }
}
