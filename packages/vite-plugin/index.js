const phpCodeBlockRegex = /<\?php[\s\S]*?\?>/g

/**
 * @param {string} code
 * @returns {string}
 */
function stripPhpTags(code) {
    return code.replace(phpCodeBlockRegex, '')
}

/**
 * @param {{ path: string, extension: string }} config
 * @returns {import('vite').Plugin}
 */
export default function inertiaVolt(config) {
    return {
        name: 'inertia-volt-transformer',
        transform(src, id) {
            if (id.includes(config.path) && id.endsWith(config.extension) && id.includes('inertia') && src.includes('<?php')) {
                return {
                    code: stripPhpTags(src),
                }
            }
        }
    }
}