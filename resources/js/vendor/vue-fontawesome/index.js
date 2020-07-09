import { library }              from '@fortawesome/fontawesome-svg-core'

import {
    faGithubAlt,
}     from '@fortawesome/free-brands-svg-icons'

import {
    faDollarSign,
    faFile,
    faCalculator,
    faCopy,
    faCoins,
    faSquare,
    faLayerGroup,
    faPlus,
    faCircle,
    faPen,
    faEye,
    faTimes,
    faSave,
    faQuestionCircle,
    faAdjust,
    faEnvelope,
    faPhoneSquare,
    faFilePdf,
    faKey,
    faSignOutAlt,
    faHome,
    faCalendarMinus,
    faCaretDown,
    faCaretLeft,
    faCaretRight,
    faExternalLinkAlt,
    faFileWord,
}     from '@fortawesome/free-solid-svg-icons'

import {FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText} from '@fortawesome/vue-fontawesome'
import Vue from "vue";

library.add(
    faDollarSign,
    faFile,
    faCalculator,
    faCopy,
    faCoins,
    faSquare,
    faLayerGroup,
    faPlus,
    faCircle,
    faPen,
    faEye,
    faTimes,
    faSave,
    faQuestionCircle,
    faAdjust,
    faGithubAlt,
    faEnvelope,
    faPhoneSquare,
    faFilePdf,
    faKey,
    faSignOutAlt,
    faHome,
    faCalendarMinus,
    faCaretDown,
    faCaretLeft,
    faCaretRight,
    faExternalLinkAlt,
    faFileWord,
)

Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('font-awesome-layers', FontAwesomeLayers)
Vue.component('font-awesome-layers-text', FontAwesomeLayersText)
