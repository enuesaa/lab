import { test, expect } from 'vitest'
import { parseAttrs } from './attrs'

test('attrs test', () => {
	expect(parseAttrs('あああ')).toStrictEqual({ content: 'あああ', attrs: {} })
	expect(parseAttrs('a=(aaa) あああ')).toStrictEqual({ content: 'あああ', attrs: { a: 'aaa' } })
	expect(parseAttrs('a=(aaa) b=(bbb) あああ')).toStrictEqual({ content: 'あああ', attrs: { a: 'aaa', b: 'bbb' } })
})
