const phpCodeBlockRegex = /<\?php[\s\S]*?\?>/g

/**
 * @param {string} code
 * @returns {string}
 */
function stripPhpTags(code) {
    return code.replace(phpCodeBlockRegex, '')
}

/**
 * @param {{ path: string }} config
 * @returns {import('vite').Plugin}
 */
export default function inertiaInline(config) {
    return {
        name: 'inertia-inline',
        transform(src, id) {
            if (id.includes(config.path) && src.includes('<?php')) {
                console.log(stripPhpTags(src))
                return {
                    code: stripPhpTags(src),
                }
            }
        }
    }
}