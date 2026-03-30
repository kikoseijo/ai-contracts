<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum PendingValidationSource: string
{
    case WhatsApp = 'whatsapp';
    case Telegram = 'telegram';
    case Zapier = 'zapier';
    case Ocr = 'ocr';
    case VoiceToText = 'voice_to_text';
    case SystemProactive = 'system_proactive';
    case WebChat = 'web_chat';
    case EmailForward = 'email_forward';
    case Hub = 'hub';
    case MagicWand = 'magic_wand';
    case ZeroInbox = 'zero_inbox';

    public function label(): string
    {
        return match ($this) {
            self::WhatsApp => 'WhatsApp',
            self::Telegram => 'Telegram',
            self::Zapier => 'Zapier',
            self::Ocr => 'OCR',
            self::VoiceToText => 'Voz a texto',
            self::SystemProactive => 'Sistema',
            self::WebChat => 'Chat web',
            self::EmailForward => 'Email',
            self::Hub => 'Hub IA',
            self::MagicWand => 'Varita magica',
            self::ZeroInbox => 'Zero-Inbox',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::WhatsApp => 'green',
            self::Telegram => 'sky',
            self::Zapier => 'amber',
            self::Ocr => 'zinc',
            self::VoiceToText => 'violet',
            self::SystemProactive => 'zinc',
            self::WebChat => 'indigo',
            self::EmailForward => 'sky',
            self::Hub => 'amber',
            self::MagicWand => 'amber',
            self::ZeroInbox => 'amber',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::WhatsApp, self::Telegram => 'chat-bubble-left-right',
            self::Zapier => 'bolt',
            self::Ocr => 'camera',
            self::VoiceToText => 'microphone',
            self::SystemProactive => 'cpu-chip',
            self::WebChat => 'globe-alt',
            self::EmailForward => 'envelope',
            self::Hub => 'sparkles',
            self::MagicWand => 'sparkles',
            self::ZeroInbox => 'inbox-arrow-down',
        };
    }
}
