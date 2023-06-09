[titleEn]: <>(Jest tests for the administration)
[hash]: <>(article:testing_jest)

This little guide will guide you how to write unit tests for the administration in Shopware 6.

## Topic Overview
* [When to write tests](#when-to-write-tests)
* [Prerequisites](#prerequisites)
* [Test file location](#test-file-location)
* [Test commands](#test-commands)
    * [Run all tests](#run-all-unit-tests)
    * [Run changed files](#run-only-changed-files)
* [Setup for testing services and es modules](#setup-for-testing-services-and-es-modules)
* [Setup for testing Vue components](#setup-for-testing-vue-components)
* [Write tests for components](#write-tests-for-components)
    * [Example test structure](#example-test-structure)

## When should I write unit tests
You should write a unit test for every functional change. It should guarantee that 
your written code works and that a third developer doesn't break the functionality with his code.

With a good test coverage we can have the confidence to deploy a stable software without extra
manual testing.

## Prerequisites
We are using [Jest](https://jestjs.io/) as our testing framework. It is a solid foundation and widely
used by many developers. Before you are reading this guide you have to make sure that you understand the
basics of unit tests and how Jest works.

You can find good source for best practices in this Github Repo: 
[https://github.com/goldbergyoni/javascript-testing-best-practices](https://github.com/goldbergyoni/javascript-testing-best-practices) 

## Test file location
The test files are placed in the same directory as the file which should be tested.
The file name is the same with the suffix `.spec.js` or `spec.ts`.

## Test commands
Before you are using the commands make sure that you installed all dependencies for your administration.
If you didn't have done this already then you can use this Composer command:
`composer run init:js`

#### Run all unit tests:  
This command executes all unit tests and show you a complete code coverage.  
`composer run admin:unit`

#### Run only changed files:  
This command executes only unit tests on changed files. It automatically restarts if a file
get saved. This should be used during the development of unit tests.  
`composer run admin:unit:watch`

## Setup for testing services and ES modules
Services and isolated EcmaScript modules are good testable because
you can import them directly without mocking or stubbing dependencies.

Lets have a look at an example:

```javascript
// sanitizer.helper.spec.js

import Sanitizer from 'src/core/helper/sanitizer.helper';

describe('core/helper/sanitizer.helper.js', () => {
    it('should sanitize the html', () => {
        expect(Sanitizer.sanitize('<A/hREf="j%0aavas%09cript%0a:%09con%0afirm%0d``">z'))
            .toBe('<a href="j%0aavas%09cript%0a:%09con%0afirm%0d``">z</a>');
    });
    
    it('should remove script functions from dom elements', () => {
        expect(Sanitizer.sanitize('<details open ontoggle=confirm()>'))
            .toBe('<details open=""></details>');
    });
    
    it('should remove script functions completely', () => {
        expect(Sanitizer.sanitize(`<script y="><">/*<script* */prompt()</script`))
            .toBe('');
    });

    it('should sanitize js in links', () => {
        expect(Sanitizer.sanitize('<a href=javas&#99;ript:alert(1)>click'))
            .toBe('<a>click</a>');
    });

    // ...more tests 
});
``` 

The service can be used isolated and therefore is easy to test.

## Setup for testing Vue components
We are using the [Vue Test Utils](https://vue-test-utils.vuejs.org/) for easier testing of Vue components. When you don't
have experience with testing Vue components it is useful to read some basic guides how to do this. The main part of
testing components is similar in Shopware 6.

But there are some important differences. We can't test components that easily like in other Vue projects because we
are supporting template inheritance and extendability for third party developers. This causes overhead which we need
to bear in mind.

We are using a global object as an interface for the whole administration. Every component gets registered to this 
object, e.g. `Shopware.Component.register()`. Therefore, we have access to Component with the `Shopware.Component.build()`
method. This creates a native Vue component with a working template. Every override and extension from another
components are resolved in the built component.

### Practical example
Fot better understanding how to write component tests for Shopware 6 let's write a test. In our example
we are using the component `sw-multi-select`.

When you want to mount your component it needs to be imported first:
```javascript
// test/app/component/form/select/base/sw-multi-select.spec.js

import 'src/app/component/form/select/base/sw-multi-select';
```

You see that we import the `sw-multi-select` without saving the return value. This
blackbox import only executes code. But this is important because this registers
the component to the Shopware object:
```javascript
// src/app/component/form/select/base/sw-multi-select.js

Shopware.Component.register('sw-multi-select', {
    // The vue component
});
```

In the next step we can mount our Vue component which we get from the global Shopware object:
```javascript
// test/app/component/form/select/base/sw-multi-select.spec.js

import 'src/app/component/form/select/base/sw-multi-select';

shallowMount(Shopware.Component.build('sw-multi-select'));
```

The `build` method resolves the twig template and returns a vue component. Now you can test the component like any other
Vue component. Lets try to write our first test: 
```javascript
// test/app/component/form/select/base/sw-multi-select.spec.js

import { shallowMount } from '@vue/test-utils';
import 'src/app/component/form/select/base/sw-multi-select';

describe('components/sw-multi-select', () => {
    let wrapper;

    beforeEach(() => {
        wrapper = shallowMount(Shopware.Component.build('sw-multi-select'));
    });

    afterEach(() => {
        wrapper.destroy();
    });

    it('should be a Vue.js component', () => {
        expect(wrapper.vm).toBeTruthy();
    });
});
```
We create a new `wrapper` before each test. This contains our component. In our first test we only
check if the wrapper is a Vue instance. 

Now lets start the watcher to see if the test works. You can do this with our PSH command `composer run admin:unit:watch`.
You should see a result like this: `Test Suites: 1 passed, 1 total`. Now we have a working test. You
should also see several warnings like this:

- `[Vue warn]: Missing required prop: "options"`
- `[Vue warn]: Missing required prop: "value"`
- `[Vue warn]: Unknown custom element: <sw-select-base> - did you register the component correctly? ...`

The first two warnings are solved easily by providing the required props to our shallowMount:
```javascript
wrapper = shallowMount(Shopware.Component.build('sw-multi-select'), {
    props: {
        options: [],
        value: ''
    }
});
```

Now you should only see the last warning with an unknown custom element. The reason for this is that
most components are containing other components. In our case the `sw-multi-select` needs the 
`sw-select-base` component. Now we have several solutions to solve this. The two most common ways
are stubbing or using the component.

```javascript
import 'src/app/component/form/select/base/sw-select-base'; // Option 2: You need to import the component first before using it

wrapper = shallowMount(Shopware.Component.build('sw-multi-select'), {
    props: {
        options: [],
        value: ''
    },
    stubs: {
        'sw-select-base': true, // Option 1: Auto Stub the component
        'sw-select-base': Shopware.Component.build('sw-select-base'), // Option 2: Create the component
    }
});
```

You need to choose which way is needed. Many tests do not need the real component. But in our case we
need the real implementation. You will see that if we import another component that they can create
also warnings. Lets solve all warnings and then we should have a code like this:

```javascript
// test/app/component/form/select/base/sw-multi-select.spec.js

import { shallowMount } from '@vue/test-utils';
import 'src/app/component/form/select/base/sw-multi-select';
import 'src/app/component/form/select/base/sw-select-base';
import 'src/app/component/form/field-base/sw-block-field';
import 'src/app/component/form/field-base/sw-base-field';
import 'src/app/component/form/field-base/sw-field-error';
import 'src/app/component/form/select/base/sw-select-selection-list';
import 'src/app/component/form/select/base/sw-select-result-list';
import 'src/app/component/utils/sw-popover';
import 'src/app/component/form/select/base/sw-select-result';
import 'src/app/component/base/sw-highlight-text';
import 'src/app/component/base/sw-label';
import 'src/app/component/base/sw-button';

describe('components/sw-multi-select', () => {
    let wrapper;

    beforeEach(() => {
        wrapper = shallowMount(Shopware.Component.build('sw-multi-select'), {
            props: {
                options: [],
                value: ''
            },
            stubs: {
                'sw-select-base': Shopware.Component.build('sw-select-base'),
                'sw-block-field': Shopware.Component.build('sw-block-field'),
                'sw-base-field': Shopware.Component.build('sw-base-field'),
                'sw-icon': '<div></div>',
                'sw-field-error': Shopware.Component.build('sw-field-error'),
                'sw-select-selection-list': Shopware.Component.build('sw-select-selection-list'),
                'sw-select-result-list': Shopware.Component.build('sw-select-result-list'),
                'sw-popover': Shopware.Component.build('sw-popover'),
                'sw-select-result': Shopware.Component.build('sw-select-result'),
                'sw-highlight-text': Shopware.Component.build('sw-highlight-text'),
                'sw-label': Shopware.Component.build('sw-label'),
                'sw-button': Shopware.Component.build('sw-button')
            }
        });
    });

    afterEach(() => {
        wrapper.destroy();
    });

    it('should be a Vue.js component', () => {
        expect(wrapper.vm).toBeTruthy();
    });
});
```

The more components you are depending the more you have to create a complex setup for the test. Your 
component get also depends on other dependencies like `$tc`, directives or injections. When you are
using this you need to mock them also. I show you here some common warnings:

#### Warning 
`[Vue warn]: Error in render: "TypeError: $tc is not a function"`

#### Solution:
```javascript
shallowMount(Shopware.Component.build('your-component'), {
    mocks: {
        $tc: key => key // your mock (here a simple function returning the translation path)
    }
});
```

#### Warning:
`[Vue warn]: Failed to resolve directive: popover`

#### Solution:
You need to use [localVue](https://vue-test-utils.vuejs.org/api/#createlocalvue) to provide the directive mock.

```javascript
import { shallowMount, createLocalVue } from '@vue/test-utils';

const localVue = createLocalVue();
localVue.directive('popover', {}); // add directive mock to localVue

shallowMount(Shopware.Component.build('your-component'), {
    localVue
});
```

#### Warning:
`[Vue warn]: Injection "repositoryFactory" not found`

#### Solution:
You need to provide the injected data, services...

```javascript
shallowMount(Shopware.Component.build('your-component'), {
    provide: {
        repositoryFactory: {
            create: () => 'fooBar', // you need to mock the return values for your test
            search: () => 'fooBar' // you need to mock the return values for your test
        }
    }
});
```

#### Warning:
`[Vue warn]: Error in foo: "TypeError: Cannot read property 'create' of undefined"`

#### Solution:
This could causes several reason. The best way to find out the solution is to look at the source of the
code and find out what is missing. In this example the service `repositoryFactory` is missing:

```javascript
Shopware.Service('repositoryFactory').create('product');
```

To fix this you need to add the mocked service before all tests. In our case we need to register the
service:

```javascript
beforeAll(() => {
  Shopware.Service.register('repositoryFactory', {
    // your service mock
  });
});
```


## Write tests for components
After setting up your component test you need to write your tests. A good way to write them is to test input
and output. The most common tests are:

- set Vue Props and check if component looks correctly
- interact with the DOM and check if the desired behaviour is happening

But it depends on what you are trying to achieve with your component. Here are some examples:
```javascript
it('should render uppercase transformation when checkbox is checked', () => {
    wrapper.setProps({ value: 'This is an example' });
    
    const checkboxShowUppercase = wrapper.find('.checkbox-show-uppercase');
    expect(checkboxShowUppercase.element.value).toBeTruthy();

    const labelText = wrapper.find('.field-label').text();
    expect(labelText).toContain('THIS IS AN EXAMPLE');
})

it('should disable uppercase transformation when checkbox is unchecked', () => {
    wrapper.setProps({ value: 'This is an example' });

    const checkboxShowUppercase = wrapper.find('.checkbox-show-uppercase');
    
    expect(checkboxShowUppercase.element.value).toBeTruthy(); 
    checkboxShowUppercase.trigger('click');
    expect(checkboxShowUppercase.element.value).toBeFalsy();

    const labelText = wrapper.find('.field-label').text();
    expect(labelText).toContain('This is an example');
})


it('should emit the new uppercase value', () => {
    wrapper.setProps({ value: 'This is an example' });
    
    expect(wrapper.emitted().length).toBe(0);

    const updateTextValueButton = wrapper.find('.button-updateTextValue');
    updateTextValueButton.trigger('click');

    expect(wrapper.emitted().length).toBe(1);
    expect(wrapper.emitted().input).arrayContaining(['THIS IS AN EXAMPLE']);
})

it('should render a new joke from api', async () => {
    jokeService.getJoke = jest.fn(() => {
        return Promise.resolve({ joke: 'What did one wall say to the other? Meet you at the corner!' });
    });

    const actualJoke = wrapper.find('.joke');
    expect(actualJoke.text()).toEqual('');

    const fetchJoke = wrapper.find('.button-fetchJoke');
    fetchJoke.trigger('click');

    await wrapper.vm.$nextTick();

    expect(actualJoke.text()).toEqual('What did one wall say to the other? Meet you at the corner!');
    jokeService.getJoke.mockReset();
})
```


### Example test structure

```typescript
import {shallowMount, createLocalVue, Wrapper} from '@vue/test-utils';
import flushPromises from 'flush-promises';

// add additional parameters to change options for the test
async function createWrapper(/* options = {} */): Wrapper {
    // add localVue only if needed
    const localVue = createLocalVue();

    // prefer shallowMount over normal mount
    return shallowMount(await Shopware.Component.build('sw-your-component-for-test'), {
        // localVue only if needed
        localVue,
        // add stubs for missing component
        stubs: {
            'sw-missing-component-one': Shopware.Component.build('sw-missing-component-one'),
            'sw-missing-component-two': Shopware.Component.build('sw-missing-component-two'),
        },
        mocks: {
            // add mocks if needed
        },
        // needed if you interact with elements
        attachTo: document.body,

        // ...options,
    });
}

describe('the/path/to/the/component', () => {
    let wrapper: Wrapper;

    beforeAll(async () => {
        // generate all needed mocks, etc.
    })

    beforeEach(async () => {
        // reset all mocks and state changes to default
        wrapper = await createWrapper();
        
        // wait for created hook etc.
        await flushPromises();
    })

    afterEach(async () => {
        // cleanup everything

        // destroy the existing wrapper
        if (wrapper) {
            await wrapper.destroy();
        }

        // wait until all promises are finished
        await flushPromises();
    })

    it('should be a Vue.js component', () => {
        expect(wrapper.vm).toBeTruthy();
    });

    // Add more component tests
})
```
