<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

/**
 * Eventos canónicos que el Hub emite vía webhook a satélites y clientes externos.
 */
enum WebhookEvent: string
{
    case TaskCompleted = 'task.completed';
    case TaskStatusChanged = 'task.status_changed';
    case AgentExecutionCompleted = 'agent.execution.completed';
    case ExtractionCompleted = 'extraction.completed';
    case ExtractionFailed = 'extraction.failed';
    case QuotaUpdated = 'quota.updated';
    case SchemaDiscovered = 'schema.discovered';
    case UsageReported = 'usage.reported';
    case VaultDocumentStatusChanged = 'vault.document.status_changed';
    case QuotaSync = 'billing.quota_sync';
    case GovernanceInsightGenerated = 'governance.insight_generated';
}
