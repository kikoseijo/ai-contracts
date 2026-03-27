# Changelog

Todos los cambios notables de este paquete se documentan en este archivo.

## [Unreleased]

## 2026-03-27

- **feat:** introduce task_type routing in ExecuteAgentTaskRequest and swarm provisioning in ProvisionTenantResponseDTO (`4d94337`)

- **feat:** add WebhookEvent to multiple webhook DTOs and implement PayloadPolymorphicCast for dynamic payload handling (`edccebe`)
- **feat:** add LeadCaptured event to WebhookEvent enum (`1fe9438`)
- **feat:** add HubWebhookEnvelopeDTO for unified webhook endpoint (`05cd4d5`)
- **feat:** add new webhook events for quota synchronization and governance insights (`311b8c8`)
- **docs:** update HUB_ROUTE_MATRIX and SATELLITE_INTEGRATION_GUIDE with new webhook endpoints and event mappings (`0012338`)
- **chore:** add PHPUnit configuration and Pest testing framework with initial test cases (`0de5204`)
- **refactor:** remove fix_datacollection_to_array.php script and update DataCollection properties to typed arrays (`7d40ee0`)
- **docs:** update HUB_ROUTE_MATRIX with new request and response DTOs for agent configuration and vault synchronization (`fc4cab2`)
- **feat:** add hydrateOutput to PayloadHydrator and make message optional in ConversationalPayloadDTO (`14226cd`)
- **refactor:** enhance DTOs with private setters and introduce DeepCloneable and RedisSafeSerialization (`9d5e4ca`)

## 2026-03-26

- **refactor:** replace DataCollection with typed arrays in DTOs for improved type safety (`e1195da`)
- **fix:** use BasePayloadData instead of union in AgenticTaskRequestDTO (`0b18e34`)
- **refactor:** enforce strict BasePayloadData for ExecuteAgentTaskRequest (`72dd4b9`)
- **fix:** remove dead toResponse method to avoid conflict with calculateResponseStatus (`a3ba476`)
- **chore:** unify webhook signatures and enforce HTTP status codes in DTOs (`5dea049`)
- **docs:** enhance DTO guidelines with examples and clarify rules for constructor usage (`483b2ff`)
- **docs:** add versioning policy and update DTO guidelines for strict SemVer compliance (`de022bf`)
- **refactor:** standardize DTO methods to return JSON responses and update collection usage (`20714c9`)
- **refactor:** update DTO properties to use DataCollection for improved type safety (`c0a2e71`)
- **feat:** add architectural guidelines and strict rules for DTOs and controllers (`d700ef6`)
- **fix:** enforce strict typing in AgenticTaskRequestDTO removing array fallback (`2ce2e78`)
- **fix:** restore missing input_payload property in AgenticTaskRequestDTO (`14a80fb`)
- **feat:** add translations, icons, and tailwind colors to LogLevel, VaultDocumentType and VaultType enums (`7df2499`)
- **fix:** add default fallback color to HandlerSlug (`564b1f2`)
- **chore:** update HandlerSlug colors to match TailwindCSS palette (`d485acd`)
- **feat:** add descriptions and localization support to HandlerSlug enum (`b3a0910`)
- **feat:** add color method to HandlerSlug enum for UI badges (`8e783e1`)
- **feat:** add FinancialExtractor case to HandlerSlug enum (`0c877e0`)
- **feat:** add CustomsAdvisor case to HandlerSlug enum (`3e3c517`)
- **feat:** create TaskOutputPayloadDTO for output payload structure from the Hub (`a140e73`)
- **feat:** add BulkTaskStatusResponseDTO and TaskStatusItemDTO for bulk task status (`5f45483`)

## 2026-03-25

- **fix:** allow SpokeToolExecutionRequestDTO to receive empty arguments (`3679242`)
- **fix:** add missing import for VaultItemDTO in VaultCreatedResponseDTO (`0ed7f63`)

## 2026-03-24

- **feat:** add strict DTOs and Enums for SunnyGestor SLA contract (`c055910`)
- **refactor:** clean up duplicated and unused DTOs across Network and Spoke/Responses (`1c40c89`)
- **docs:** add HUB_ROUTE_MATRIX and HUB_SPOKE_HTTP_CONTRACT documentation (`f63bd5c`)
- **feat:** add SyncAgentVaultsRequest for hot-swapping vaults (`d4b0094`)
- **feat:** add default agent and vault ids to ProvisionTenantResponseDTO (`6802a11`)
- **feat:** introduce new DTOs for Spoke tool execution requests and responses (`b6c7441`)
- **docs:** rewrite README with strict typing philosophy and real examples (`c3e0f13`)
- **refactor:** apply strict typing, union types and fix missing imports across DTOs (`97f7ceb`)
- **refactor:** enhance DTO structure by consolidating related types (`a69931b`)

## 2026-03-23

- **init:** Initial commit — composer.json, README, DTOs, service provider, and documentation for Hub/Spoke HTTP contracts (`4aed02e`)
- **chore:** package setup, licensing, autoloading, and dependency configuration (`f8e0eb2`..`a446e3e`)
