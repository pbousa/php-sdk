<?php
/**
 * Copyright 2014 Photo Booth Options, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0.html
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
 
namespace Pbo\Common;
 
use Pbo\Common\Facade\Facade;
use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Service\Builder\ServiceBuilderLoader;
 
/**
 * Base class for interacting with web service clients
 */
class Pbo extends ServiceBuilder
{
	/**
	 * @var string Current version of the SDK
     */
	const VERSION = '1.0.0';
	
}