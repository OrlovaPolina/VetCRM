import './bootstrap';
import * as Popper from '@popperjs/core'
window.Popper = Popper

import 'bootstrap' 

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { Tooltip } from 'bootstrap'
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))