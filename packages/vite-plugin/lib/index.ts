import type { Plugin } from 'vite';
import { stripPhpTags } from './utils';

type InertiaVoltConfig = {
	path: string;
	extension: string;
};

export default function inertiaVolt(config: InertiaVoltConfig): Plugin {
	return {
		name: 'inertia-volt-transformer',
		transform(src, id) {
			if (
				id.includes(config.path) &&
				id.endsWith(config.extension) &&
				id.includes('inertia') &&
				src.includes('<?php')
			) {
				return {
					code: stripPhpTags(src),
				};
			}
		},
	};
}
