const testReDoS = () => {
    // Using the new safer regex approach
    const escapeRegex = (value) => {
        return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    };

    const filter = (array, term) => {
        const escapedTerm = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const matcher = new RegExp(escapedTerm, "i");
        return array.filter(value => matcher.test(value));
    };

    // Test with malicious input
    const array = ["normal text"];
    console.time('RegExp Test');
    
    // Malicious input with catastrophic backtracking - should no longer cause issues
    const maliciousInput = 'a' + 'a?'.repeat(100) + 'a';
    try {
        const result = filter(array, maliciousInput);
        console.log('Filter completed successfully');
        console.log('Result:', result);
    } catch (e) {
        console.log('RegExp execution timed out or failed:', e);
    }
    console.timeEnd('RegExp Test');

    // Test edge cases
    console.log('\nTesting edge cases:');
    const edgeCases = [
        '',                              // Empty string
        '.*+?^${}()|[]\\',              // All special regex characters
        'normal.text',                   // Text with period
        '[test]',                        // Text with brackets
        'test{1,2}',                     // Text with quantifiers
        '     ',                         // Just whitespace
        'a'.repeat(1000)                 // Very long input
    ];

    edgeCases.forEach(testCase => {
        console.log(`\nTesting: "${testCase}"`);
        try {
            const result = filter(array, testCase);
            console.log('Success - Result:', result);
        } catch (e) {
            console.log('Failed:', e);
        }
    });
};

testReDoS();