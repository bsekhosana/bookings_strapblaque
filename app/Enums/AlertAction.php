<?php

namespace App\Enums;

enum AlertAction: string
{
    case Approve = 'approve';
    case Delete = 'delete';
    case Deny = 'deny';
    case Destroy = 'destroy';
    case Remove = 'remove';
    case Restore = 'restore';
    case Send = 'send';
    case Store = 'store';
    case Trash = 'trash';
    case Update = 'update';

    private static function actionPastTense(self $key): string
    {
        return match ($key) {
            self::Approve => 'approved',
            self::Delete => 'deleted',
            self::Deny => 'denied',
            self::Destroy => 'destroyed',
            self::Remove => 'removed',
            self::Restore => 'restored',
            self::Send => 'sent',
            self::Store => 'stored',
            self::Trash => 'trashed',
            self::Update => 'updated',
        };
    }

    public function message(bool $success, ?string $context = null): string
    {
        if ($success) {
            $message = $context
                ? sprintf('%s %s successfully!', $context, self::actionPastTense($this))
                : sprintf('%s successfully!', self::actionPastTense($this));
        } else {
            $message = $context
                ? sprintf('failed to %s %s, please try again!', $this->value, $context)
                : sprintf('failed to %s, please try again!', $this->value);
        }

        return ucfirst($message);
    }
}
