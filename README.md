# Twig Entity Load, Drupal 8 Module

This module allows loading different kind of entities on the twigs templates, you can also specify how to receive the entity as a rendered entity or as an object.

Twig functions available:

load_entity(), return a rendered or not rendered entity, parameters:
- entity type (The entity type).
- id (The entity id).
- view mode (The entity view mode).
- render  (1 = to receive a rendered entity, 0 = receive the entity object).

load_entity_field(), return a rendered or not rendered entity field, parameters:
- entity type (The entity type).
- id (The entity id).
- field name (The field entity name).
- render  (1 = to receive a rendered entity field, 0 = receive the entity field object).