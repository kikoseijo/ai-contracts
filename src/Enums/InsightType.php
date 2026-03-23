<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

enum InsightType: string
{
    case QuotaWarning = 'quota_warning';
    case ErrorRate = 'error_rate';
    case PerformanceDegradation = 'performance_degradation';
    case WebhookFailure = 'webhook_failure';
    case AnomalyDetected = 'anomaly_detected';
    case HealthCheck = 'health_check';
}
