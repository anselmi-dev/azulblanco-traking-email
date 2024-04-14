// import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard';
import Tooltip from "@ryangjchandler/alpine-tooltip";

Alpine.plugin(Clipboard);

Alpine.plugin(Tooltip);

Livewire.start()


