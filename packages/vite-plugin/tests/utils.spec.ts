import { expect, it } from 'vitest'
import { readFile } from "fs/promises"
import { resolve, dirname } from "path"
import { fileURLToPath } from 'url';
import { stripPhpTags } from '../lib/utils';

async function getContents(snapshotFile: string) {
    const __filename = fileURLToPath(import.meta.url);
    const __dirname = dirname(__filename);

    const content = await readFile(resolve(__dirname, `./snapshots/${snapshotFile}`))

    return content.toString()
}

it('should strip php code in a valid component', async () => {
    const file = await getContents('Valid.inertia.vue');
    const expected = await getContents('Valid.vue')

    expect(stripPhpTags(file)).toBe(expected)
})

it('should keep file with invalid php tags as is', async () => {
    const file = await getContents('InvalidPhpTag.inertia.vue');

    expect(stripPhpTags(file)).toBe(file)
})

it('should keep file with php tag that is not closed', async () => {
    const file = await getContents('WithoutClosingTag.inertia.vue');

    expect(stripPhpTags(file)).toBe(file)
})
