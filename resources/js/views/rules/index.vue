<template class="">
    <div class="container rules-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">{{ $t('home') }}</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $t('history') }}</li>
            </ol>
        </nav>
        <div class="rules-page">
            <h1>{{ $t('rules_title') }}</h1>
            <section class="rules-section">
                <h2>{{ $t('schedule_title') }}</h2>
                <ul class="rules-list">
                    <li v-html="$t('schedule_open_chrono')"></li>
                    <li v-html="$t('schedule_close_entry')"></li>
                    <li v-html="$t('schedule_close_chrono')"></li>
                    <li v-html="$t('schedule_briefing')"></li>
                    <li v-html="$t('schedule_start_game')"></li>
                    <li v-html="$t('schedule_break')"></li>
                    <li v-html="$t('schedule_start_second_part')"></li>
                    <li v-html="$t('schedule_end_game')"></li>
                </ul>
                <p class="important-note" v-html="$t('schedule_absent_player')"></p>
            </section>

            <section class="rules-section">
                <h2>{{ $t('chrono_title') }}</h2>
                <p>{{ $t('chrono_validation_criteria') }}</p>
                <ul class="rules-list">
                    <li v-html="$t('chrono_pistol_revolver')"></li>
                    <li v-html="$t('chrono_shotgun')"></li>
                    <li v-html="$t('chrono_rifle_smg')"></li>
                    <li v-html="$t('chrono_dmr') + $t('chrono_dmr_note')"></li>
                    <li v-html="$t('chrono_sniper') + $t('chrono_sniper_note')"></li>
                    <li v-html="$t('chrono_lmg') + $t('chrono_lmg_note')"></li>
                </ul>
                <p>{{ $t('chrono_bb_sampling') }}</p>
                <p class="important-note" v-html="$t('chrono_power_tampering')"></p>
                <p>{{ $t('chrono_role_by_replica') }}</p>
                <p>{{ $t('chrono_hpa_gas_pistols') }}</p>
                <p>{{ $t('chrono_ww2_replicas') }}</p>
                <p class="important-note" v-html="$t('chrono_ask_organization')"></p>
            </section>

            <section class="rules-section">
                <h2>{{ $t('security_title') }}</h2>
                <ol class="rules-list numbered">
                    <li v-html="$t('security_glasses_mandatory')"></li>
                    <li>{{ $t('security_face_mask_recommended') }}</li>
                    <li v-html="$t('security_climbing_prohibited')"></li>
                    <li v-html="$t('security_smoking_alcohol_prohibited')"></li>
                    <li v-html="$t('security_laser_prohibited')"></li>
                    <li v-html="$t('security_throwing_objects_prohibited')"></li>
                    <li v-html="$t('security_no_shooting_organization')"></li>
                    <li v-html="$t('security_eliminated_player_movement')"></li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('game_specific_title') }}</h2>
                <ol class="rules-list numbered">
                    <li v-html="$t('game_specific_fire_selector')"></li>
                    <li>{{ $t('game_specific_engagement_suppression') }}</li>
                    <li v-html="$t('game_specific_dmr_lmg_sniper')"></li>
                    <li v-html="$t('game_specific_no_blind_fire')"></li>
                    <li v-html="$t('game_specific_no_moving_furniture')"></li>
                    <li>{{ $t('game_specific_knife_kill') }}</li>
                    <li v-html="$t('game_specific_no_rifles_pistol_zones')"></li>
                    <li v-html="$t('game_specific_no_shooting_gaps')"></li>
                    <li v-html="$t('game_specific_no_red_lights')"></li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('grenades_title') }}</h2>
                <ol class="rules-list numbered">
                    <li v-html="$t('grenades_no_pyro')"></li>
                    <li>{{ $t('grenades_throwing_rules') }}</li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('shield_title') }}</h2>
                <ol class="rules-list numbered">
                    <li>{{ $t('shield_secondary_weapon_only') }}</li>
                    <li>{{ $t('shield_firing_rules') }}</li>
                    <li v-html="$t('shield_movement_restrictions')"></li>
                    <li>{{ $t('shield_grenade_effect') }}</li>
                    <li v-html="$t('shield_realistic_only')"></li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('elimination_respawn_title') }}</h2>
                <ol class="rules-list numbered">
                    <li v-html="$t('elimination_signal') + $t('elimination_no_enemy_backline')"></li>
                    <li>{{ $t('elimination_friendly_fire') }}</li>
                    <li v-html="$t('elimination_touch_flag')"></li>
                    <li v-html="$t('elimination_no_communication')"></li>
                    <li v-html="$t('elimination_no_respawn_siege')"></li>
                    <li v-html="$t('elimination_respawn_safety_zone')"></li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('healing_title') }}</h2>
                <p>{{ $t('healing_intro') }}</p>
                <ul class="rules-list">
                    <li v-html="$t('healing_medic')"></li>
                    <li v-html="$t('healing_tourniquet')"></li>
                    <li>{{ $t('healing_medic_healed') }}</li>
                </ul>
            </section>

            <section class="rules-section">
                <h2>{{ $t('minimum_requirements_title') }}</h2>
                <ol class="rules-list numbered">
                    <li>{{ $t('minimum_requirements_booking') }}</li>
                    <li v-html="$t('minimum_requirements_minors')"></li>
                    <li>{{ $t('minimum_requirements_identification') }}</li>
                </ol>
            </section>

            <section class="rules-section">
                <h2>{{ $t('behavior_companionship_title') }}</h2>
                <p class="important-note" v-html="$t('behavior_companionship_intro')"></p>
                <ol class="rules-list numbered">
                    <li>{{ $t('behavior_follow_staff') }}</li>
                    <li v-html="$t('behavior_no_talking_enemies')"></li>
                    <li>{{ $t('behavior_disagreement_protocol') }}
                        <ol type="a" class="sub-list">
                            <li>{{ $t('behavior_disagreement_step_1') }}</li>
                            <li>{{ $t('behavior_disagreement_step_2') }}</li>
                            <li>{{ $t('behavior_disagreement_step_3') }}</li>
                        </ol>
                    </li>
                    <li v-html="$t('behavior_no_immortals')"></li>
                    <li v-html="$t('behavior_no_shooting_props')"></li>
                    <li v-html="$t('behavior_no_littering')"></li>
                    <li v-html="$t('behavior_no_dishonest_behavior')"></li>
                </ol>
                <p class="important-note" v-html="$t('behavior_consequences')"></p>
            </section>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
/* ... tus estilos CSS ... */
</style>
