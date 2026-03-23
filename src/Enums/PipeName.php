<?php

declare(strict_types=1);

namespace Sunnyface\Contracts\Enums;

/**
 * Registro canónico de todos los Pipes del pipeline cognitivo.
 * Actualizar cuando se añada o renombre un Pipe.
 */
enum PipeName: string
{
    case AnalyzeIntent = 'AnalyzeIntentPipe';
    case AssembleClassifierPrompt = 'AssembleClassifierPromptPipe';
    case AssembleContextPrompt = 'AssembleContextPromptPipe';
    case AssembleFinancialPrompt = 'AssembleFinancialPromptPipe';
    case AssembleTranslationPrompt = 'AssembleTranslationPromptPipe';
    case AssembleVisionPrompt = 'AssembleVisionPromptPipe';
    case ChunkDocument = 'ChunkDocumentPipe';
    case CleanupVaultFile = 'CleanupVaultFilePipe';
    case CognitiveFire = 'CognitiveFirewallPipe';
    case ConvertFileToBase64 = 'ConvertFileToBase64Pipe';
    case DownloadVaultFile = 'DownloadVaultFilePipe';
    case EmbedChunks = 'EmbedChunksPipe';
    case ExecuteChatLlm = 'ExecuteChatLlmPipe';
    case ExecuteClassifierLlm = 'ExecuteClassifierLlmPipe';
    case ExecuteFinancialLlm = 'ExecuteFinancialLlmPipe';
    case ExecuteTextLlm = 'ExecuteTextLlmPipe';
    case ExecuteTranslationLlm = 'ExecuteTranslationLlmPipe';
    case ExecuteVisionLlm = 'ExecuteVisionLlmPipe';
    case ExtractText = 'ExtractTextPipe';
    case HydrateClassifierOutput = 'HydrateClassifierOutputPipe';
    case HydrateExtractorOutput = 'HydrateExtractorOutputPipe';
    case HydrateFinancialOutput = 'HydrateFinancialOutputPipe';
    case HydrateTranslationOutput = 'HydrateTranslationOutputPipe';
    case InspectDocumentIntent = 'InspectDocumentIntentPipe';
    case LoadAssignedSchema = 'LoadAssignedSchemaPipe';
    case LoadAvailableSchemas = 'LoadAvailableSchemasPipe';
    case RecordPipelineTransition = 'RecordPipelineTransition';
    case SemanticSearch = 'SemanticSearchPipe';
    case ValidateExecutionDto = 'ValidateExecutionDtoPipe';
}
